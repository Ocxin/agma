<?php

/**
 * Pure-PHP X.509 Parser
 *
 * PHP version 5
 *
 * Encode and decode X.509 certificates.
 *
 * The extensions are from {@link http://tools.ietf.org/html/rfc5280 RFC5280} and
 * {@link http://web.archive.org/web/19961027104704/http://www3.netscape.com/eng/security/cert-exts.html Netscape Certificate Extensions}.
 *
 * Note that loading an X.509 certificate and resaving it may invalidate the signature.  The reason being that the signature is based on a
 * portion of the certificate that contains optional parameters with default values.  ie. if the parameter isn't there the default value is
 * used.  Problem is, if the parameter is there and it just so happens to have the default value there are two ways that that parameter can
 * be encoded.  It can be encoded explicitly or left out all together.  This would effect the signature value and thus may invalidate the
 * the certificate all together unless the certificate is re-signed.
 *
 * @category  File
 * @package   X509
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2012 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */

namespace phpseclib3\File;

use ParagonIE\ConstantTime\Base64;
use ParagonIE\ConstantTime\Hex;
use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\Common\PublicKey;
use phpseclib3\Crypt\DSA;
use phpseclib3\Crypt\EC;
use phpseclib3\Crypt\Hash;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\RSA\Formats\Keys\PSS;
use phpseclib3\Exception\UnsupportedAlgorithmException;
use phpseclib3\File\ASN1\Element;
use phpseclib3\File\ASN1\Maps;
use phpseclib3\Math\BigInteger;

/**
 * Pure-PHP X.509 Parser
 *
 * @package X509
 * @author  Jim Wigginton <terrafrost@php.net>
 * @access  public
 */
class X509
{
    /**
     * Flag to only accept signatures signed by certificate authorities
     *
     * Not really used anymore but retained all the same to suppress E_NOTICEs from old installs
     *
     * @access public
     */
    const VALIDATE_SIGNATURE_BY_CA = 1;

    /**
     * Return internal array representation
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_ARRAY = 0;
    /**
     * Return string
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_STRING = 1;
    /**
     * Return ASN.1 name string
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_ASN1 = 2;
    /**
     * Return OpenSSL compatible array
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_OPENSSL = 3;
    /**
     * Return canonical ASN.1 RDNs string
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_CANON = 4;
    /**
     * Return name hash for file indexing
     *
     * @access public
     * @see \phpseclib3\File\X509::getDN()
     */
    const DN_HASH = 5;

    /**
     * Save as PEM
     *
     * ie. a base64-encoded PEM with a header and a footer
     *
     * @access public
     * @see \phpseclib3\File\X509::saveX509()
     * @see \phpseclib3\File\X509::saveCSR()
     * @see \phpseclib3\File\X509::saveCRL()
     */
    const FORMAT_PEM = 0;
    /**
     * Save as DER
     *
     * @access public
     * @see \phpseclib3\File\X509::saveX509()
     * @see \phpseclib3\File\X509::saveCSR()
     * @see \phpseclib3\File\X509::saveCRL()
     */
    const FORMAT_DER = 1;
    /**
     * Save as a SPKAC
     *
     * @access public
     * @see \phpseclib3\File\X509::saveX509()
     * @see \phpseclib3\File\X509::saveCSR()
     * @see \phpseclib3\File\X509::saveCRL()
     *
     * Only works on CSRs. Not currently supported.
     */
    const FORMAT_SPKAC = 2;
    /**
     * Auto-detect the format
     *
     * Used only by the load*() functions
     *
     * @access public
     * @see \phpseclib3\File\X509::saveX509()
     * @see \phpseclib3\File\X509::saveCSR()
     * @see \phpseclib3\File\X509::saveCRL()
     */
    const FORMAT_AUTO_DETECT = 3;

    /**
     * Attribute value disposition.
     * If disposition is >= 0, this is the index of the target value.
     */
    const ATTR_ALL = -1; // All attribute values (array).
    const ATTR_APPEND = -2; // Add a value.
    const ATTR_REPLACE = -3; // Clear first, then add a value.

    /**
     * Distinguished Name
     *
     * @var array
     * @access private
     */
    private $dn;

    /**
     * Public key
     *
     * @var string|PublicKey
     * @access private
     */
    private $publicKey;

    /**
     * Private key
     *
     * @var string|PrivateKey
     * @access private
     */
    private $privateKey;

    /**
     * Object identifiers for X.509 certificates
     *
     * @var array
     * @access private
     * @link http://en.wikipedia.org/wiki/Object_identifier
     */
    private $oids;

    /**
     * The certificate authorities
     *
     * @var array
     * @access private
     */
    private $CAs;

    /**
     * The currently loaded certificate
     *
     * @var array
     * @access private
     */
    private $currentCert;

    /**
     * The signature subject
     *
     * There's no guarantee \phpseclib3\File\X509 is going to re-encode an X.509 cert in the same way it was originally
     * encoded so we take save the portion of the original cert that the signature would have made for.
     *
     * @var string
     * @access private
     */
    private $signatureSubject;

    /**
     * Certificate Start Date
     *
     * @var string
     * @access private
     */
    private $startDate;

    /**
     * Certificate End Date
     *
     * @var string|Element
     * @access private
     */
    private $endDate;

    /**
     * Serial Number
     *
     * @var string
     * @access private
     */
    private $serialNumber;

    /**
     * Key Identifier
     *
     * See {@link http://tools.ietf.org/html/rfc5280#section-4.2.1.1 RFC5280#section-4.2.1.1} and
     * {@link http://tools.ietf.org/html/rfc5280#section-4.2.1.2 RFC5280#section-4.2.1.2}.
     *
     * @var string
     * @access private
     */
    private $currentKeyIdentifier;

    /**
     * CA Flag
     *
     * @var bool
     * @access private
     */
    private $caFlag = false;

    /**
     * SPKAC Challenge
     *
     * @var string
     * @access private
     */
    private $challenge;

    /**
     * @var array
     * @access private
     */
    private $extensionValues = [];

    /**
     * OIDs loaded
     *
     * @var bool
     * @access private
     */
    private static $oidsLoaded = false;

    /**
     * Recursion Limit
     *
     * @var int
     * @access private
     */
    private static $recur_limit = 5;

    /**
     * URL fetch flag
     *
     * @var bool
     * @access private
     */
    private static $disable_url_fetch = false;

    /**
     * @var array
     * @access private
     */
    private static $extensions = [];

    /**
     * @var ?array
     * @access private
     */
    private $ipAddresses = null;

    /**
     * @var ?array
     * @access private
     */
    private $domains = null;

    /**
     * Default Constructor.
     *
     * @return \phpseclib3\File\X509
     * @access public
     */
    public function __construct()
    {
        // Explicitly Tagged Module, 1988 Syntax
        // http://tools.ietf.org/html/rfc5280#appendix-A.1

        if (!self::$oidsLoaded) {
            // OIDs from RFC5280 and those RFCs mentioned in RFC5280#section-4.1.1.2
            ASN1::loadOIDs([
                //'id-pkix' => '1.3.6.1.5.5.7',
                //'id-pe' => '1.3.6.1.5.5.7.1',
                //'id-qt' => '1.3.6.1.5.5.7.2',
                //'id-kp' => '1.3.6.1.5.5.7.3',
                //'id-ad' => '1.3.6.1.5.5.7.48',
                'id-qt-cps' => '1.3.6.1.5.5.7.2.1',
                'id-qt-unotice' => '1.3.6.1.5.5.7.2.2',
                'id-ad-ocsp' => '1.3.6.1.5.5.7.48.1',
                'id-ad-caIssuers' => '1.3.6.1.5.5.7.48.2',
                'id-ad-timeStamping' => '1.3.6.1.5.5.7.48.3',
                'id-ad-caRepository' => '1.3.6.1.5.5.7.48.5',
                //'id-at' => '2.5.4',
                'id-at-name' => '2.5.4.41',
                'id-at-surname' => '2.5.4.4',
                'id-at-givenName' => '2.5.4.42',
                'id-at-initials' => '2.5.4.43',
                'id-at-generationQualifier' => '2.5.4.44',
                'id-at-commonName' => '2.5.4.3',
                'id-at-localityName' => '2.5.4.7',
                'id-at-stateOrProvinceName' => '2.5.4.8',
                'id-at-organizationName' => '2.5.4.10',
                'id-at-organizationalUnitName' => '2.5.4.11',
                'id-at-title' => '2.5.4.12',
                'id-at-description' => '2.5.4.13',
                'id-at-dnQualifier' => '2.5.4.46',
                'id-at-countryName' => '2.5.4.6',
                'id-at-serialNumber' => '2.5.4.5',
                'id-at-pseudonym' => '2.5.4.65',
                'id-at-postalCode' => '2.5.4.17',
                'id-at-streetAddress' => '2.5.4.9',
                'id-at-uniqueIdentifier' => '2.5.4.45',
                'id-at-role' => '2.5.4.72',
                'id-at-postalAddress' => '2.5.4.16',

                //'id-domainComponent' => '0.9.2342.19200300.100.1.25',
                //'pkcs-9' => '1.2.840.113549.1.9',
                'pkcs-9-at-emailAddress' => '1.2.840.113549.1.9.1',
                //'id-ce' => '2.5.29',
                'id-ce-authorityKeyIdentifier' => '2.5.29.35',
                'id-ce-subjectKeyIdentifier' => '2.5.29.14',
                'id-ce-keyUsage' => '2.5.29.15',
                'id-ce-privateKeyUsagePeriod' => '2.5.29.16',
                'id-ce-certificatePolicies' => '2.5.29.32',
                //'anyPolicy' => '2.5.29.32.0',

                'id-ce-policyMappings' => '2.5.29.33',

                'id-ce-subjectAltName' => '2.5.29.17',
                'id-ce-issuerAltName' => '2.5.29.18',
                'id-ce-subjectDirectoryAttributes' => '2.5.29.9',
                'id-ce-basicConstraints' => '2.5.29.19',
                'id-ce-nameConstraints' => '2.5.29.30',
                'id-ce-policyConstraints' => '2.5.29.36',
                'id-ce-cRLDistributionPoints' => '2.5.29.31',
                'id-ce-extKeyUsage' => '2.5.29.37',
                //'anyExtendedKeyUsage' => '2.5.29.37.0',
                'id-kp-serverAuth' => '1.3.6.1.5.5.7.3.1',
                'id-kp-clientAuth' => '1.3.6.1.5.5.7.3.2',
                'id-kp-codeSigning' => '1.3.6.1.5.5.7.3.3',
                'id-kp-emailProtection' => '1.3.6.1.5.5.7.3.4',
                'id-kp-timeStamping' => '1.3.6.1.5.5.7.3.8',
                'id-kp-OCSPSigning' => '1.3.6.1.5.5.7.3.9',
                'id-ce-inhibitAnyPolicy' => '2.5.29.54',
                'id-ce-freshestCRL' => '2.5.29.46',
                'id-pe-authorityInfoAccess' => '1.3.6.1.5.5.7.1.1',
                'id-pe-subjectInfoAccess' => '1.3.6.1.5.5.7.1.11',
                'id-ce-cRLNumber' => '2.5.29.20',
                'id-ce-issuingDistributionPoint' => '2.5.29.28',
                'id-ce-deltaCRLIndicator' => '2.5.29.27',
                'id-ce-cRLReasons' => '2.5.29.21',
                'id-ce-certificateIssuer' => '2.5.29.29',
                'id-ce-holdInstructionCode' => '2.5.29.23',
                //'holdInstruction' => '1.2.840.10040.2',
                'id-holdinstruction-none' => '1.2.840.10040.2.1',
                'id-holdinstruction-callissuer' => '1.2.840.10040.2.2',
                'id-holdinstruction-reject' => '1.2.840.10040.2.3',
                'id-ce-invalidityDate' => '2.5.29.24',

                'rsaEncryption' => '1.2.840.113549.1.1.1',
                'md2WithRSAEncryption' => '1.2.840.113549.1.1.2',
                'md5WithRSAEncryption' => '1.2.840.113549.1.1.4',
                'sha1WithRSAEncryption' => '1.2.840.113549.1.1.5',
                'sha224WithRSAEncryption' => '1.2.840.113549.1.1.14',
                'sha256WithRSAEncryption' => '1.2.840.113549.1.1.11',
                'sha384WithRSAEncryption' => '1.2.840.113549.1.1.12',
                'sha512WithRSAEncryption' => '1.2.840.113549.1.1.13',

                'id-ecPublicKey' => '1.2.840.10045.2.1',
                'ecdsa-with-SHA1' => '1.2.840.10045.4.1',
                // from https://tools.ietf.org/html/rfc5758#section-3.2
                'ecdsa-with-SHA224' => '1.2.840.10045.4.3.1',
                'ecdsa-with-SHA256' => '1.2.840.10045.4.3.2',
                'ecdsa-with-SHA384' => '1.2.840.10045.4.3.3',
                'ecdsa-with-SHA512' => '1.2.840.10045.4.3.4',

                'id-dsa' => '1.2.840.10040.4.1',
                'id-dsa-with-sha1' => '1.2.840.10040.4.3',
                // from https://tools.ietf.org/html/rfc5758#section-3.1
                'id-dsa-with-sha224' => '2.16.840.1.101.3.4.3.1',
                'id-dsa-with-sha256' => '2.16.840.1.101.3.4.3.2',

                // from https://tools.ietf.org/html/rfc8410:
                'id-Ed25519' => '1.3.101.112',
                'id-Ed448' => '1.3.101.113',

                'id-RSASSA-PSS' => '1.2.840.113549.1.1.10',

                //'id-sha224' => '2.16.840.1.101.3.4.2.4',
                //'id-sha256' => '2.16.840.1.101.3.4.2.1',
                //'id-sha384' => '2.16.840.1.101.3.4.2.2',
                //'id-sha512' => '2.16.840.1.101.3.4.2.3',
                //'id-GostR3411-94-with-GostR3410-94' => '1.2.643.2.2.4',
                //'id-GostR3411-94-with-GostR3410-2001' => '1.2.643.2.2.3',
                //'id-GostR3410-2001' => '1.2.643.2.2.20',
                //'id-GostR3410-94' => '1.2.643.2.2.19',
                // Netscape Object Identifiers from "Netscape Certificate Extensions"
                'netscape' => '2.16.840.1.113730',
                'netscape-cert-extension' => '2.16.840.1.113730.1',
                'netscape-cert-type' => '2.16.840.1.113730.1.1',
                'netscape-comment' => '2.16.840.1.113730.1.13',
                'netscape-ca-policy-url' => '2.16.840.1.113730.1.8',
                // the following are X.509 extensions not supported by phpseclib
                'id-pe-logotype' => '1.3.6.1.5.5.7.1.12',
                'entrustVersInfo' => '1.2.840.113533.7.65.0',
                'verisignPrivate' => '2.16.840.1.113733.1.6.9',
                // for Certificate Signing Requests
                // see http://tools.ietf.org/html/rfc2985
                'pkcs-9-at-unstructuredName' => '1.2.840.113549.1.9.2', // PKCS #9 unstructured name
                'pkcs-9-at-challengePassword' => '1.2.840.113549.1.9.7', // Challenge password for certificate revocations
                'pkcs-9-at-extensionRequest' => '1.2.840.113549.1.9.14' // Certificate extension request
            ]);
        }
    }

    /**
     * Load X.509 certificate
     *
     * Returns an associative array describing the X.509 cert or a false if the cert failed to load
     *
     * @param string $cert
     * @param int $mode
     * @access public
     * @return mixed
     */
    public function loadX509($cert, $mode = self::FORMAT_AUTO_DETECT)
    {
        if (is_array($cert) && isset($cert['tbsCertificate'])) {
            unset($this->currentCert);
            unset($this->currentKeyIdentifier);
            $this->dn = $cert['tbsCertificate']['subject'];
            if (!isset($this->dn)) {
                return false;
            }
            $this->currentCert = $cert;

            $currentKeyIdentifier = $this->getExtension('id-ce-subjectKeyIdentifier');
            $this->currentKeyIdentifier = is_string($currentKeyIdentifier) ? $currentKeyIdentifier : null;

            unset($this->signatureSubject);

            return $cert;
        }

        if ($mode != self::FORMAT_DER) {
            $newcert = ASN1::extractBER($cert);
            if ($mode == self::FORMAT_PEM && $cert == $newcert) {
                return false;
            }
            $cert = $newcert;
        }

        if ($cert === false) {
            $this->currentCert = false;
            return false;
        }

        $decoded = ASN1::decodeBER($cert);

        if (!empty($decoded)) {
            $x509 = ASN1::asn1map($decoded[0], Maps\Certificate::MAP);
        }
        if (!isset($x509) || $x509 === false) {
            $this->currentCert = false;
            return false;
        }

        $this->signatureSubject = substr($cert, $decoded[0]['content'][0]['start'], $decoded[0]['content'][0]['length']);

        if ($this->isSubArrayValid($x509, 'tbsCertificate/extensions')) {
            $this->mapInExtensions($x509, 'tbsCertificate/extensions');
        }
        $this->mapInDNs($x509, 'tbsCertificate/issuer/rdnSequence');
        $this->mapInDNs($x509, 'tbsCertificate/subject/rdnSequence');

        $key = $x509['tbsCertificate']['subjectPublicKeyInfo'];
        $key = ASN1::encodeDER($key, Maps\SubjectPublicKeyInfo::MAP);
        $x509['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'] =
            "-----BEGIN PUBLIC KEY-----\r\n" .
            chunk_split(base64_encode($key), 64) .
            "-----END PUBLIC KEY-----";

        $this->currentCert = $x509;
        $this->dn = $x509['tbsCertificate']['subject'];

        $currentKeyIdentifier = $this->getExtension('id-ce-subjectKeyIdentifier');
        $this->currentKeyIdentifier = is_string($currentKeyIdentifier) ? $currentKeyIdentifier : null;

        return $x509;
    }

    /**
     * Save X.509 certificate
     *
     * @param array $cert
     * @param int $format optional
     * @access public
     * @return string
     */
    public function saveX509($cert, $format = self::FORMAT_PEM)
    {
        if (!is_array($cert) || !isset($cert['tbsCertificate'])) {
            return false;
        }

        switch (true) {
            // "case !$a: case !$b: break; default: whatever();" is the same thing as "if ($a && $b) whatever()"
            case !($algorithm = $this->subArray($cert, 'tbsCertificate/subjectPublicKeyInfo/algorithm/algorithm')):
            case is_object($cert['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey']):
                break;
            default:
                $cert['tbsCertificate']['subjectPublicKeyInfo'] = new Element(
                    base64_decode(preg_replace('#-.+-|[\r\n]#', '', $cert['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey']))
                );
        }

        if ($algorithm == 'rsaEncryption') {
            $cert['signatureAlgorithm']['parameters'] = null;
            $cert['tbsCertificate']['signature']['parameters'] = null;
        }

        $filters = [];
        $type_utf8_string = ['type' => ASN1::TYPE_UTF8_STRING];
        $filters['tbsCertificate']['signature']['parameters'] = $type_utf8_string;
        $filters['tbsCertificate']['signature']['issuer']['rdnSequence']['value'] = $type_utf8_string;
        $filters['tbsCertificate']['issuer']['rdnSequence']['value'] = $type_utf8_string;
        $filters['tbsCertificate']['subject']['rdnSequence']['value'] = $type_utf8_string;
        $filters['tbsCertificate']['subjectPublicKeyInfo']['algorithm']['parameters'] = $type_utf8_string;
        $filters['signatureAlgorithm']['parameters'] = $type_utf8_string;
        $filters['authorityCertIssuer']['directoryName']['rdnSequence']['value'] = $type_utf8_string;
        //$filters['policyQualifiers']['qualifier'] = $type_utf8_string;
        $filters['distributionPoint']['fullName']['directoryName']['rdnSequence']['value'] = $type_utf8_string;
        $filters['directoryName']['rdnSequence']['value'] = $type_utf8_string;

        foreach (self::$extensions as $extension) {
            $filters['tbsCertificate']['extensions'][] = $extension;
        }

        /* in the case of policyQualifiers/qualifier, the type has to be \phpseclib3\File\ASN1::TYPE_IA5_STRING.
           \phpseclib3\File\ASN1::TYPE_PRINTABLE_STRING will cause OpenSSL's X.509 parser to spit out random
           characters.
         */
        $filters['policyQualifiers']['qualifier']
            = ['type' => ASN1::TYPE_IA5_STRING];

        ASN1::setFilters($filters);

        $this->mapOutExtensions($cert, 'tbsCertificate/extensions');
        $this->mapOutDNs($cert, 'tbsCertificate/issuer/rdnSequence');
        $this->mapOutDNs($cert, 'tbsCertificate/subject/rdnSequence');

        $cert = ASN1::encodeDER($cert, Maps\Certificate::MAP);

        switch ($format) {
            case self::FORMAT_DER:
                return $cert;
            // case self::FORMAT_PEM:
            default:
                return "-----BEGIN CERTIFICATE-----\r\n" . chunk_split(Base64::encode($cert), 64) . '-----END CERTIFICATE-----';
        }
    }

    /**
     * Map extension values from octet string to extension-specific internal
     *   format.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapInExtensions(&$root, $path)
    {
        $extensions = &$this->subArrayUnchecked($root, $path);

        if ($extensions) {
            for ($i = 0; $i < count($extensions); $i++) {
                $id = $extensions[$i]['extnId'];
                $value = &$extensions[$i]['extnValue'];
                /* [extnValue] contains the DER encoding of an ASN.1 value
                   corresponding to the extension type identified by extnID */
                $map = $this->getMapping($id);
                if (!is_bool($map)) {
                    $decoder = $id == 'id-ce-nameConstraints' ?
                        [static::class, 'decodeNameConstraintIP'] :
                        [static::class, 'decodeIP'];
                    $decoded = ASN1::decodeBER($value);
                    $mapped = ASN1::asn1map($decoded[0], $map, ['iPAddress' => $decoder]);
                    $value = $mapped === false ? $decoded[0] : $mapped;

                    if ($id == 'id-ce-certificatePolicies') {
                        for ($j = 0; $j < count($value); $j++) {
                            if (!isset($value[$j]['policyQualifiers'])) {
                                continue;
                            }
                            for ($k = 0; $k < count($value[$j]['policyQualifiers']); $k++) {
                                $subid = $value[$j]['policyQualifiers'][$k]['policyQualifierId'];
                                $map = $this->getMapping($subid);
                                $subvalue = &$value[$j]['policyQualifiers'][$k]['qualifier'];
                                if ($map !== false) {
                                    $decoded = ASN1::decodeBER($subvalue);
                                    $mapped = ASN1::asn1map($decoded[0], $map);
                                    $subvalue = $mapped === false ? $decoded[0] : $mapped;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Map extension values from extension-specific internal format to
     *   octet string.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapOutExtensions(&$root, $path)
    {
        $extensions = &$this->subArray($root, $path, !empty($this->extensionValues));

        foreach ($this->extensionValues as $id => $data) {
            extract($data);
            $newext = [
                'extnId' => $id,
                'extnValue' => $value,
                'critical' => $critical
            ];
            if ($replace) {
                foreach ($extensions as $key => $value) {
                    if ($value['extnId'] == $id) {
                        $extensions[$key] = $newext;
                        continue 2;
                    }
                }
            }
            $extensions[] = $newext;
        }

        if (is_array($extensions)) {
            $size = count($extensions);
            for ($i = 0; $i < $size; $i++) {
                if ($extensions[$i] instanceof Element) {
                    continue;
                }

                $id = $extensions[$i]['extnId'];
                $value = &$extensions[$i]['extnValue'];

                switch ($id) {
                    case 'id-ce-certificatePolicies':
                        for ($j = 0; $j < count($value); $j++) {
                            if (!isset($value[$j]['policyQualifiers'])) {
                                continue;
                            }
                            for ($k = 0; $k < count($value[$j]['policyQualifiers']); $k++) {
                                $subid = $value[$j]['policyQualifiers'][$k]['policyQualifierId'];
                                $map = $this->getMapping($subid);
                                $subvalue = &$value[$j]['policyQualifiers'][$k]['qualifier'];
                                if ($map !== false) {
                                    // by default \phpseclib3\File\ASN1 will try to render qualifier as a \phpseclib3\File\ASN1::TYPE_IA5_STRING since it's
                                    // actual type is \phpseclib3\File\ASN1::TYPE_ANY
                                    $subvalue = new Element(ASN1::encodeDER($subvalue, $map));
                                }
                            }
                        }
                        break;
                    case 'id-ce-authorityKeyIdentifier': // use 00 as the serial number instead of an empty string
                        if (isset($value['authorityCertSerialNumber'])) {
                            if ($value['authorityCertSerialNumber']->toBytes() == '') {
                                $temp = chr((ASN1::CLASS_CONTEXT_SPECIFIC << 6) | 2) . "\1\0";
                                $value['authorityCertSerialNumber'] = new Element($temp);
                            }
                        }
                }

                /* [extnValue] contains the DER encoding of an ASN.1 value
                   corresponding to the extension type identified by extnID */
                $map = $this->getMapping($id);
                if (is_bool($map)) {
                    if (!$map) {
                        //user_error($id . ' is not a currently supported extension');
                        unset($extensions[$i]);
                    }
                } else {
                    $value = ASN1::encodeDER($value, $map, ['iPAddress' => [static::class, 'encodeIP']]);
                }
            }
        }
    }

    /**
     * Map attribute values from ANY type to attribute-specific internal
     *   format.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapInAttributes(&$root, $path)
    {
        $attributes = &$this->subArray($root, $path);

        if (is_array($attributes)) {
            for ($i = 0; $i < count($attributes); $i++) {
                $id = $attributes[$i]['type'];
                /* $value contains the DER encoding of an ASN.1 value
                   corresponding to the attribute type identified by type */
                $map = $this->getMapping($id);
                if (is_array($attributes[$i]['value'])) {
                    $values = &$attributes[$i]['value'];
                    for ($j = 0; $j < count($values); $j++) {
                        $value = ASN1::encodeDER($values[$j], Maps\AttributeValue::MAP);
                        $decoded = ASN1::decodeBER($value);
                        if (!is_bool($map)) {
                            $mapped = ASN1::asn1map($decoded[0], $map);
                            if ($mapped !== false) {
                                $values[$j] = $mapped;
                            }
                            if ($id == 'pkcs-9-at-extensionRequest' && $this->isSubArrayValid($values, $j)) {
                                $this->mapInExtensions($values, $j);
                            }
                        } elseif ($map) {
                            $values[$j] = $value;
                        }
                    }
                }
            }
        }
    }

    /**
     * Map attribute values from attribute-specific internal format to
     *   ANY type.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapOutAttributes(&$root, $path)
    {
        $attributes = &$this->subArray($root, $path);

        if (is_array($attributes)) {
            $size = count($attributes);
            for ($i = 0; $i < $size; $i++) {
                /* [value] contains the DER encoding of an ASN.1 value
                   corresponding to the attribute type identified by type */
                $id = $attributes[$i]['type'];
                $map = $this->getMapping($id);
                if ($map === false) {
                    //user_error($id . ' is not a currently supported attribute', E_USER_NOTICE);
                    unset($attributes[$i]);
                } elseif (is_array($attributes[$i]['value'])) {
                    $values = &$attributes[$i]['value'];
                    for ($j = 0; $j < count($values); $j++) {
                        switch ($id) {
                            case 'pkcs-9-at-extensionRequest':
                                $this->mapOutExtensions($values, $j);
                                break;
                        }

                        if (!is_bool($map)) {
                            $temp = ASN1::encodeDER($values[$j], $map);
                            $decoded = ASN1::decodeBER($temp);
                            $values[$j] = ASN1::asn1map($decoded[0], Maps\AttributeValue::MAP);
                        }
                    }
                }
            }
        }
    }

    /**
     * Map DN values from ANY type to DN-specific internal
     *   format.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapInDNs(&$root, $path)
    {
        $dns = &$this->subArray($root, $path);

        if (is_array($dns)) {
            for ($i = 0; $i < count($dns); $i++) {
                for ($j = 0; $j < count($dns[$i]); $j++) {
                    $type = $dns[$i][$j]['type'];
                    $value = &$dns[$i][$j]['value'];
                    if (is_object($value) && $value instanceof Element) {
                        $map = $this->getMapping($type);
                        if (!is_bool($map)) {
                            $decoded = ASN1::decodeBER($value);
                            $value = ASN1::asn1map($decoded[0], $map);
                        }
                    }
                }
            }
        }
    }

    /**
     * Map DN values from DN-specific internal format to
     *   ANY type.
     *
     * @param array $root (by reference)
     * @param string $path
     * @access private
     */
    private function mapOutDNs(&$root, $path)
    {
        $dns = &$this->subArray($root, $path);

        if (is_array($dns)) {
            $size = count($dns);
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < count($dns[$i]); $j++) {
                    $type = $dns[$i][$j]['type'];
                    $value = &$dns[$i][$j]['value'];
                    if (is_object($value) && $value instanceof Element) {
                        continue;
                    }

                    $map = $this->getMapping($type);
                    if (!is_bool($map)) {
                        $value = new Element(ASN1::encodeDER($value, $map));
                    }
                }
            }
        }
    }

    /**
     * Associate an extension ID to an extension mapping
     *
     * @param string $extnId
     * @access private
     * @return mixed
     */
    private function getMapping($extnId)
    {
        if (!is_string($extnId)) { // eg. if it's a \phpseclib3\File\ASN1\Element object
            return true;
        }

        if (isset(self::$extensions[$extnId])) {
            return self::$extensions[$extnId];
        }

        switch ($extnId) {
            case 'id-ce-keyUsage':
                return Maps\KeyUsage::MAP;
            case 'id-ce-basicConstraints':
                return Maps\BasicConstraints::MAP;
            case 'id-ce-subjectKeyIdentifier':
                return Maps\KeyIdentifier::MAP;
            case 'id-ce-cRLDistributionPoints':
                return Maps\CRLDistributionPoints::MAP;
            case 'id-ce-authorityKeyIdentifier':
                return Maps\AuthorityKeyIdentifier::MAP;
            case 'id-ce-certificatePolicies':
                return Maps\CertificatePolicies::MAP;
            case 'id-ce-extKeyUsage':
                return Maps\ExtKeyUsageSyntax::MAP;
            case 'id-pe-authorityInfoAccess':
                return Maps\AuthorityInfoAccessSyntax::MAP;
            case 'id-ce-subjectAltName':
                return Maps\SubjectAltName::MAP;
            case 'id-ce-subjectDirectoryAttributes':
                return Maps\SubjectDirectoryAttributes::MAP;
            case 'id-ce-privateKeyUsagePeriod':
                return Maps\PrivateKeyUsagePeriod::MAP;
            case 'id-ce-issuerAltName':
                return Maps\IssuerAltName::MAP;
            case 'id-ce-policyMappings':
                return Maps\PolicyMappings::MAP;
            case 'id-ce-nameConstraints':
                return Maps\NameConstraints::MAP;

            case 'netscape-cert-type':
                return Maps\netscape_cert_type::MAP;
            case 'netscape-comment':
                return Maps\netscape_comment::MAP;
            case 'netscape-ca-policy-url':
                return Maps\netscape_ca_policy_url::MAP;

            // since id-qt-cps isn't a constructed type it will have already been decoded as a string by the time it gets
            // back around to asn1map() and we don't want it decoded again.
            //case 'id-qt-cps':
            //    return Maps\CPSuri::MAP;
            case 'id-qt-unotice':
                return Maps\UserNotice::MAP;

            // the following OIDs are unsupported but we don't want them to give notices when calling saveX509().
            case 'id-pe-logotype': // http://www.ietf.org/rfc/rfc3709.txt
            case 'entrustVersInfo':
            // http://support.microsoft.com/kb/287547
            case '1.3.6.1.4.1.311.20.2': // szOID_ENROLL_CERTTYPE_EXTENSION
            case '1.3.6.1.4.1.311.21.1': // szOID_CERTSRV_CA_VERSION
            // "SET Secure Electronic Transaction Specification"
            // http://www.maithean.com/docs/set_bk3.pdf
            case '2.23.42.7.0': // id-set-hashedRootKey
            // "Certificate Transparency"
            // https://tools.ietf.org/html/rfc6962
            case '1.3.6.1.4.1.11129.2.4.2':
            // "Qualified Certificate statements"
            // https://tools.ietf.org/html/rfc3739#section-3.2.6
            case '1.3.6.1.5.5.7.1.3':
                return true;

            // CSR attributes
            case 'pkcs-9-at-unstructuredName':
                return Maps\PKCS9String::MAP;
            case 'pkcs-9-at-challengePassword':
                return Maps\DirectoryString::MAP;
            case 'pkcs-9-at-extensionRequest':
                return Maps\Extensions::MAP;

            // CRL extensions.
            case 'id-ce-cRLNumber':
                return Maps\CRLNumber::MAP;
            case 'id-ce-deltaCRLIndicator':
                return Maps\CRLNumber::MAP;
            case 'id-ce-issuingDistributionPoint':
                return Maps\IssuingDistributionPoint::MAP;
            case 'id-ce-freshestCRL':
                return Maps\CRLDistributionPoints::MAP;
            case 'id-ce-cRLReasons':
                return Maps\CRLReason::MAP;
            case 'id-ce-invalidityDate':
                return Maps\InvalidityDate::MAP;
            case 'id-ce-certificateIssuer':
                return Maps\CertificateIssuer::MAP;
            case 'id-ce-holdInstructionCode':
                return Maps\HoldInstructionCode::MAP;
            case 'id-at-postalAddress':
                return Maps\PostalAddress::MAP;
        }

        return false;
    }

    /**
     * Load an X.509 certificate as a certificate authority
     *
     * @param string $cert
     * @access public
     * @return bool
     */
    public function loadCA($cert)
    {
        $olddn = $this->dn;
        $oldcert = $this->currentCert;
        $oldsigsubj = $this->signatureSubject;
        $oldkeyid = $this->currentKeyIdentifier;

        $cert = $this->loadX509($cert);
        if (!$cert) {
            $this->dn = $olddn;
            $this->currentCert = $oldcert;
            $this->signatureSubject = $oldsigsubj;
            $this->currentKeyIdentifier = $oldkeyid;

            return false;
        }

        /* From RFC5280 "PKIX Certificate and CRL Profile":

           If the keyUsage extension is present, then the subject public key
           MUST NOT be used to verify signatures on certificates or CRLs unless
           the corresponding keyCertSign or cRLSign bit is set. */
        //$keyUsage = $this->getExtension('id-ce-keyUsage');
        //if ($keyUsage && !in_array('keyCertSign', $keyUsage)) {
        //    return false;
        //}

        /* From RFC5280 "PKIX Certificate and CRL Profile":

           The cA boolean indicates whether the certified public key may be used
           to verify certificate signatures.  If the cA boolean is not asserted,
           then the keyCertSign bit in the key usage extension MUST NOT be
           asserted.  If the basic constraints extension is not present in a
           version 3 certificate, or the extension is present but the cA boolean
           is not asserted, then the certified public key MUST NOT be used to
           verify certificate signatures. */
        //$basicConstraints = $this->getExtension('id-ce-basicConstraints');
        //if (!$basicConstraints || !$basicConstraints['cA']) {
        //    return false;
        //}

        $this->CAs[] = $cert;

        $this->dn = $olddn;
        $this->currentCert = $oldcert;
        $this->signatureSubject = $oldsigsubj;

        return true;
    }

    /**
     * Validate an X.509 certificate against a URL
     *
     * From RFC2818 "HTTP over TLS":
     *
     * Matching is performed using the matching rules specified by
     * [RFC2459].  If more than one identity of a given type is present in
     * the certificate (e.g., more than one dNSName name, a match in any one
     * of the set is considered acceptable.) Names may contain the wildcard
     * character * which is considered to match any single domain name
     * component or component fragment. E.g., *.a.com matches foo.a.com but
     * not bar.foo.a.com. f*.com matches foo.com but not bar.com.
     *
     * @param string $url
     * @access public
     * @return bool
     */
    public function validateURL($url)
    {
        if (!is_array($this->currentCert) || !isset($this->currentCert['tbsCertificate'])) {
            return false;
        }

        $components = parse_url($url);
        if (!isset($components['host'])) {
            return false;
        }

        if ($names = $this->getExtension('id-ce-subjectAltName')) {
            foreach ($names as $name) {
                foreach ($name as $key => $value) {
                    $value = str_replace(['.', '*'], ['\.', '[^.]*'], $value);
                    switch ($key) {
                        case 'dNSName':
                            /* From RFC2818 "HTTP over TLS":

                               If a subjectAltName extension of type dNSName is present, that MUST
                               be used as the identity. Otherwise, the (most specific) Common Name
                               field in the Subject field of the certificate MUST be used. Although
                               the use of the Common Name is existing practice, it is deprecated and
                               Certification Authorities are encouraged to use the dNSName instead. */
                            if (preg_match('#^' . $value . '$#', $components['host'])) {
                                return true;
                            }
                            break;
                        case 'iPAddress':
                            /* From RFC2818 "HTTP over TLS":

                               In some cases, the URI is specified as an IP address rather than a
                               hostname. In this case, the iPAddress subjectAltName must be present
                               in the certificate and must exactly match the IP in the URI. */
                            if (preg_match('#(?:\d{1-3}\.){4}#', $components['host'] . '.') && preg_match('#^' . $value . '$#', $components['host'])) {
                                return true;
                            }
                    }
                }
            }
            return false;
        }

        if ($value = $this->getDNProp('id-at-commonName')) {
            $value = str_replace(['.', '*'], ['\.', '[^.]*'], $value[0]);
            return preg_match('#^' . $value . '$#', $components['host']) === 1;
        }

        return false;
    }

    /**
     * Validate a date
     *
     * If $date isn't defined it is assumed to be the current date.
     *
     * @param \DateTimeInterface|string $date optional
     * @access public
     * @return bool
     */
    public function validateDate($date = null)
    {
        if (!is_array($this->currentCert) || !isset($this->currentCert['tbsCertificate'])) {
            return false;
        }

        if (!isset($date)) {
            $date = new \DateTimeImmutable('now', new \DateTimeZone(@date_default_timezone_get()));
        }

        $notBefore = $this->currentCert['tbsCertificate']['validity']['notBefore'];
        $notBefore = isset($notBefore['generalTime']) ? $notBefore['generalTime'] : $notBefore['utcTime'];

        $notAfter = $this->currentCert['tbsCertificate']['validity']['notAfter'];
        $notAfter = isset($notAfter['generalTime']) ? $notAfter['generalTime'] : $notAfter['utcTime'];

        if (is_string($date)) {
            $date = new \DateTimeImmutable($date, new \DateTimeZone(@date_default_timezone_get()));
        }

        $notBefore = new \DateTimeImmutable($notBefore, new \DateTimeZone(@date_default_timezone_get()));
        $notAfter = new \DateTimeImmutable($notAfter, new \DateTimeZone(@date_default_timezone_get()));

        return $date >= $notBefore && $date <= $notAfter;
    }

    /**
     * Fetches a URL
     *
     * @param string $url
     * @access private
     * @return bool|string
     */
    private static function fetchURL($url)
    {
        if (self::$disable_url_fetch) {
            return false;
        }

        $parts = parse_url($url);
        $data = '';
        switch ($parts['scheme']) {
            case 'http':
                $fsock = @fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80);
                if (!$fsock) {
                    return false;
                }
                fputs($fsock, "GET $parts[path] HTTP/1.0\r\n");
                fputs($fsock, "Host: $parts[host]\r\n\r\n");
                $line = fgets($fsock, 1024);
                if (strlen($line) < 3) {
                    return false;
                }
                preg_match('#HTTP/1.\d (\d{3})#', $line, $temp);
                if ($temp[1] != '200') {
                    return false;
                }

                // skip the rest of the headers in the http response
                while (!feof($fsock) && fgets($fsock, 1024) != "\r\n") {
                }

                while (!feof($fsock)) {
                    $temp = fread($fsock, 1024);
                    if ($temp === false) {
                        return false;
                    }
                    $data .= $temp;
                }

                break;
            //case 'ftp':
            //case 'ldap':
            //default:
        }

        return $data;
    }

    /**
     * Validates an intermediate cert as identified via authority info access extension
     *
     * See https://tools.ietf.org/html/rfc4325 for more info
     *
     * @param bool $caonly
     * @param int $count
     * @access private
     * @return bool
     */
    private function testForIntermediate($caonly, $count)
    {
        $opts = $this->getExtension('id-pe-authorityInfoAccess');
        if (!is_array($opts)) {
            return false;
        }
        foreach ($opts as $opt) {
            if ($opt['accessMethod'] == 'id-ad-caIssuers') {
                // accessLocation is a GeneralName. GeneralName fields support stuff like email addresses, IP addresses, LDAP,
                // etc, but we're only supporting URI's. URI's and LDAP are the only thing https://tools.ietf.org/html/rfc4325
                // discusses
                if (isset($opt['accessLocation']['uniformResourceIdentifier'])) {
                    $url = $opt['accessLocation']['uniformResourceIdentifier'];
                    break;
                }
            }
        }

        if (!isset($url)) {
            return false;
        }

        $cert = static::fetchURL($url);
        if (!is_string($cert)) {
            return false;
        }

        $parent = new static();
        $parent->CAs = $this->CAs;
        /*
         "Conforming applications that support HTTP or FTP for accessing
          certificates MUST be able to accept .cer files and SHOULD be able
          to accept .p7c files." -- https://tools.ietf.org/html/rfc4325

         A .p7c file is 'a "certs-only" CMS message as specified in RFC 2797"

         These are currently unsupported
        */
        if (!is_array($parent->loadX509($cert))) {
            return false;
        }

        if (!$parent->validateSignatureCountable($caonly, ++$count)) {
            return false;
        }

        $this->CAs[] = $parent->currentCert;
        //$this->loadCA($cert);

        return true;
    }

    /**
     * Validate a signature
     *
     * Works on X.509 certs, CSR's and CRL's.
     * Returns true if the signature is verified, false if it is not correct or null on error
     *
     * By default returns false for self-signed certs. Call validateSignature(false) to make this support
     * self-signed.
     *
     * The behavior of this function is inspired by {@link http://php.net/openssl-verify openssl_verify}.
     *
     * @param bool $caonly optional
     * @access public
     * @return mixed
     */
    public function validateSignature($caonly = true)
    {
        return $this->validateSignatureCountable($caonly, 0);
    }

    /**
     * Validate a signature
     *
     * Performs said validation whilst keeping track of how many times validation method is called
     *
     * @param bool $caonly
     * @param int $count
     * @access private
     * @return mixed
     */
    private function validateSignatureCountable($caonly, $count)
    {
        if (!is_array($this->currentCert) || !isset($this->signatureSubject)) {
            return null;
        }

        if ($count == self::$recur_limit) {
            return false;
        }

        /* TODO:
           "emailAddress attribute values are not case-sensitive (e.g., "subscriber@example.com" is the same as "SUBSCRIBER@EXAMPLE.COM")."
            -- http://tools.ietf.org/html/rfc5280#section-4.1.2.6

           implement pathLenConstraint in the id-ce-basicConstraints extension */

        switch (true) {
            case isset($this->currentCert['tbsCertificate']):
                // self-signed cert
                switch (true) {
                    case !defined('FILE_X509_IGNORE_TYPE') && $this->currentCert['tbsCertificate']['issuer'] === $this->currentCert['tbsCertificate']['subject']:
                    case defined('FILE_X509_IGNORE_TYPE') && $this->getIssuerDN(self::DN_STRING) === $this->getDN(self::DN_STRING):
                        $authorityKey = $this->getExtension('id-ce-authorityKeyIdentifier');
                        $subjectKeyID = $this->getExtension('id-ce-subjectKeyIdentifier');
                        switch (true) {
                            case !is_array($authorityKey):
                            case !$subjectKeyID:
                            case isset($authorityKey['keyIdentifier']) && $authorityKey['keyIdentifier'] === $subjectKeyID:
                                $signingCert = $this->currentCert; // working cert
                        }
                }

                if (!empty($this->CAs)) {
                    for ($i = 0; $i < count($this->CAs); $i++) {
                        // even if the cert is a self-signed one we still want to see if it's a CA;
                        // if not, we'll conditionally return an error
                        $ca = $this->CAs[$i];
                        switch (true) {
                            case !defined('FILE_X509_IGNORE_TYPE') && $this->currentCert['tbsCertificate']['issuer'] === $ca['tbsCertificate']['subject']:
                            case defined('FILE_X509_IGNORE_TYPE') && $this->getDN(self::DN_STRING, $this->currentCert['tbsCertificate']['issuer']) === $this->getDN(self::DN_STRING, $ca['tbsCertificate']['subject']):
                                $authorityKey = $this->getExtension('id-ce-authorityKeyIdentifier');
                                $subjectKeyID = $this->getExtension('id-ce-subjectKeyIdentifier', $ca);
                                switch (true) {
                                    case !is_array($authorityKey):
                                    case !$subjectKeyID:
                                    case isset($authorityKey['keyIdentifier']) && $authorityKey['keyIdentifier'] === $subjectKeyID:
                                        if (is_array($authorityKey) && isset($authorityKey['authorityCertSerialNumber']) && !$authorityKey['authorityCertSerialNumber']->equals($ca['tbsCertificate']['serialNumber'])) {
                                            break 2; // serial mismatch - check other ca
                                        }
                                        $signingCert = $ca; // working cert
                                        break 3;
                                }
                        }
                    }
                    if (count($this->CAs) == $i && $caonly) {
                        return $this->testForIntermediate($caonly, $count) && $this->validateSignature($caonly);
                    }
                } elseif (!isset($signingCert) || $caonly) {
                    return $this->testForIntermediate($caonly, $count) && $this->validateSignature($caonly);
                }
                return $this->validateSignatureHelper(
                    $signingCert['tbsCertificate']['subjectPublicKeyInfo']['algorithm']['algorithm'],
                    $signingCert['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'],
                    $this->currentCert['signatureAlgorithm']['algorithm'],
                    substr($this->currentCert['signature'], 1),
                    $this->signatureSubject
                );
            case isset($this->currentCert['certificationRequestInfo']):
                return $this->validateSignatureHelper(
                    $this->currentCert['certificationRequestInfo']['subjectPKInfo']['algorithm']['algorithm'],
                    $this->currentCert['certificationRequestInfo']['subjectPKInfo']['subjectPublicKey'],
                    $this->currentCert['signatureAlgorithm']['algorithm'],
                    substr($this->currentCert['signature'], 1),
                    $this->signatureSubject
                );
            case isset($this->currentCert['publicKeyAndChallenge']):
                return $this->validateSignatureHelper(
                    $this->currentCert['publicKeyAndChallenge']['spki']['algorithm']['algorithm'],
                    $this->currentCert['publicKeyAndChallenge']['spki']['subjectPublicKey'],
                    $this->currentCert['signatureAlgorithm']['algorithm'],
                    substr($this->currentCert['signature'], 1),
                    $this->signatureSubject
                );
            case isset($this->currentCert['tbsCertList']):
                if (!empty($this->CAs)) {
                    for ($i = 0; $i < count($this->CAs); $i++) {
                        $ca = $this->CAs[$i];
                        switch (true) {
                            case !defined('FILE_X509_IGNORE_TYPE') && $this->currentCert['tbsCertList']['issuer'] === $ca['tbsCertificate']['subject']:
                            case defined('FILE_X509_IGNORE_TYPE') && $this->getDN(self::DN_STRING, $this->currentCert['tbsCertList']['issuer']) === $this->getDN(self::DN_STRING, $ca['tbsCertificate']['subject']):
                                $authorityKey = $this->getExtension('id-ce-authorityKeyIdentifier');
                                $subjectKeyID = $this->getExtension('id-ce-subjectKeyIdentifier', $ca);
                                switch (true) {
                                    case !is_array($authorityKey):
                                    case !$subjectKeyID:
                                    case isset($authorityKey['keyIdentifier']) && $authorityKey['keyIdentifier'] === $subjectKeyID:
                                        if (is_array($authorityKey) && isset($authorityKey['authorityCertSerialNumber']) && !$authorityKey['authorityCertSerialNumber']->equals($ca['tbsCertificate']['serialNumber'])) {
                                            break 2; // serial mismatch - check other ca
                                        }
                                        $signingCert = $ca; // working cert
                                        break 3;
                                }
                        }
                    }
                }
                if (!isset($signingCert)) {
                    return false;
                }
                return $this->validateSignatureHelper(
                    $signingCert['tbsCertificate']['subjectPublicKeyInfo']['algorithm']['algorithm'],
                    $signingCert['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'],
                    $this->currentCert['signatureAlgorithm']['algorithm'],
                    substr($this->currentCert['signature'], 1),
                    $this->signatureSubject
                );
            default:
                return false;
        }
    }

    /**
     * Validates a signature
     *
     * Returns true if the signature is verified and false if it is not correct.
     * If the algorithms are unsupposed an exception is thrown.
     *
     * @param string $publicKeyAlgorithm
     * @param string $publicKey
     * @param string $signatureAlgorithm
     * @param string $signature
     * @param string $signatureSubject
     * @access private
     * @throws \phpseclib3\Exception\UnsupportedAlgorithmException if the algorithm is unsupported
     * @return bool
     */
    private function validateSignatureHelper($publicKeyAlgorithm, $publicKey, $signatureAlgorithm, $signature, $signatureSubject)
    {
        switch ($publicKeyAlgorithm) {
            case 'id-RSASSA-PSS':
                $key = RSA::loadFormat('PSS', $publicKey);
                break;
            case 'rsaEncryption':
                $key = RSA::loadFormat('PKCS8', $publicKey);
                switch ($signatureAlgorithm) {
                    case 'md2WithRSAEncryption':
                    case 'md5WithRSAEncryption':
                    case 'sha1WithRSAEncryption':
                    case 'sha224WithRSAEncryption':
                    case 'sha256WithRSAEncryption':
                    case 'sha384WithRSAEncryption':
                    case 'sha512WithRSAEncryption':
                        $key = $key
                            ->withHash(preg_replace('#WithRSAEncryption$#', '', $signatureAlgorithm))
                            ->withPadding(RSA::SIGNATURE_PKCS1);
                        break;
                    default:
                        throw new UnsupportedAlgorithmException('Signature algorithm unsupported');
                }
                break;
            case 'id-Ed25519':
            case 'id-Ed448':
                $key = EC::loadFormat('PKCS8', $publicKey);
                break;
            case 'id-ecPublicKey':
                $key = EC::loadFormat('PKCS8', $publicKey);
                switch ($signatureAlgorithm) {
                    case 'ecdsa-with-SHA1':
                    case 'ecdsa-with-SHA224':
                    case 'ecdsa-with-SHA256':
                    case 'ecdsa-with-SHA384':
                    case 'ecdsa-with-SHA512':
                        $key = $key
                            ->withHash(preg_replace('#^ecdsa-with-#', '', strtolower($signatureAlgorithm)));
                        break;
                    default:
                        throw new UnsupportedAlgorithmException('Signature algorithm unsupported');
                }
                break;
            case 'id-dsa':
                $key = DSA::loadFormat('PKCS8', $publicKey);
                switch ($signatureAlgorithm) {
                    case 'id-dsa-with-sha1':
                    case 'id-dsa-with-sha224':
                    case 'id-dsa-with-sha256':
                        $key = $key
                            ->withHash(preg_replace('#^id-dsa-with-#', '', strtolower($signatureAlgorithm)));
                        break;
                    default:
                        throw new UnsupportedAlgorithmException('Signature algorithm unsupported');
                }
                break;
            default:
                throw new UnsupportedAlgorithmException('Public key algorithm unsupported');
        }

        return $key->verify($signatureSubject, $signature);
    }

    /**
     * Sets the recursion limit
     *
     * When validating a signature it may be necessary to download intermediate certs from URI's.
     * An intermediate cert that linked to itself would result in an infinite loop so to prevent
     * that we set a recursion limit. A negative number means that there is no recursion limit.
     *
     * @param int $count
     * @access public
     */
    public static function setRecurLimit($count)
    {
        self::$recur_limit = $count;
    }

    /**
     * Prevents URIs from being automatically retrieved
     *
     * @access public
     */
    public static function disableURLFetch()
    {
        self::$disable_url_fetch = true;
    }

    /**
     * Allows URIs to be automatically retrieved
     *
     * @access public
     */
    public static function enableURLFetch()
    {
        self::$disable_url_fetch = false;
    }

    /**
     * Decodes an IP address
     *
     * Takes in a base64 encoded "blob" and returns a human readable IP address
     *
     * @param string $ip
     * @access private
     * @return string
     */
    public static function decodeIP($ip)
    {
        return inet_ntop($ip);
    }

    /**
     * Decodes an IP address in a name constraints extension
     *
     * Takes in a base64 encoded "blob" and returns a human readable IP address / mask
     *
     * @param string $ip
     * @access private
     * @return array
     */
    public static function decodeNameConstraintIP($ip)
    {
        $size = strlen($ip) >> 1;
        $mask = substr($ip, $size);
        $ip = substr($ip, 0, $size);
        return [inet_ntop($ip), inet_ntop($mask)];
    }

    /**
     * Encodes an IP address
     *
     * Takes a human readable IP address into a base64-encoded "blob"
     *
     * @param string|array $ip
     * @access private
     * @return string
     */
    public static function encodeIP($ip)
    {
        return is_string($ip) ?
            inet_pton($ip) :
            inet_pton($ip[0]) . inet_pton($ip[1]);
    }

    /**
     * "Normalizes" a Distinguished Name property
     *
     * @param string $propName
     * @access private
     * @return mixed
     */
    private function translateDNProp($propName)
    {
        switch (strtolower($propName)) {
            case 'id-at-countryname':
            case 'countryname':
            case 'c':
                return 'id-at-countryName';
            case 'id-at-organizationname':
            case 'organizationname':
            case 'o':
                return 'id-at-organizationName';
            case 'id-at-dnqualifier':
            case 'dnqualifier':
                return 'id-at-dnQualifier';
            case 'id-at-commonname':
            case 'commonname':
            case 'cn':
                return 'id-at-commonName';
            case 'id-at-stateorprovincename':
            case 'stateorprovincename':
            case 'state':
            case 'province':
            case 'provincename':
            case 'st':
                return 'id-at-stateOrProvinceName';
            case 'id-at-localityname':
            case 'localityname':
            case 'l':
                return 'id-at-localityName';
            case 'id-emailaddress':
            case 'emailaddress':
                return 'pkcs-9-at-emailAddress';
            case 'id-at-serialnumber':
            case 'serialnumber':
                return 'id-at-serialNumber';
            case 'id-at-postalcode':
            case 'postalcode':
                return 'id-at-postalCode';
            case 'id-at-streetaddress':
            case 'streetaddress':
                return 'id-at-streetAddress';
            case 'id-at-name':
            case 'name':
                return 'id-at-name';
            case 'id-at-givenname':
            case 'givenname':
                return 'id-at-givenName';
            case 'id-at-surname':
            case 'surname':
            case 'sn':
                return 'id-at-surname';
            case 'id-at-initials':
            case 'initials':
                return 'id-at-initials';
            case 'id-at-generationqualifier':
            case 'generationqualifier':
                return 'id-at-generationQualifier';
            case 'id-at-organizationalunitname':
            case 'organizationalunitname':
            case 'ou':
                return 'id-at-organizationalUnitName';
            case 'id-at-pseudonym':
            case 'pseudonym':
                return 'id-at-pseudonym';
            case 'id-at-title':
            case 'title':
                return 'id-at-title';
            case 'id-at-description':
            case 'description':
                return 'id-at-description';
            case 'id-at-role':
            case 'role':
                return 'id-at-role';
            case 'id-at-uniqueidentifier':
            case 'uniqueidentifier':
            case 'x500uniqueidentifier':
                return 'id-at-uniqueIdentifier';
            case 'postaladdress':
            case 'id-at-postaladdress':
                return 'id-at-postalAddress';
            default:
                return false;
        }
    }

    /**
     * Set a Distinguished Name property
     *
     * @param string $propName
     * @param mixed $propValue
     * @param string $type optional
     * @access public
     * @return bool
     */
    public function setDNProp($propName, $propValue, $type = 'utf8String')
    {
        if (empty($this->dn)) {
            $this->dn = ['rdnSequence' => []];
        }

        if (($propName = $this->translateDNProp($propName)) === false) {
            return false;
        }

        foreach ((array) $propValue as $v) {
            if (!is_array($v) && isset($type)) {
                $v = [$type => $v];
            }
            $this->dn['rdnSequence'][] = [
                [
                    'type' => $propName,
                    'value' => $v
                ]
            ];
        }

        return true;
    }

    /**
     * Remove Distinguished Name properties
     *
     * @param string $propName
     * @access public
     */
    public function removeDNProp($propName)
    {
        if (empty($this->dn)) {
            return;
        }

        if (($propName = $this->translateDNProp($propName)) === false) {
            return;
        }

        $dn = &$this->dn['rdnSequence'];
        $size = count($dn);
        for ($i = 0; $i < $size; $i++) {
            if ($dn[$i][0]['type'] == $propName) {
                unset($dn[$i]);
            }
        }

        $dn = array_values($dn);
        // fix for https://bugs.php.net/75433 affecting PHP 7.2
        if (!isset($dn[0])) {
            $dn = array_splice($dn, 0, 0);
        }
    }

    /**
     * Get Distinguished Name properties
     *
     * @param string $propName
     * @param array $dn optional
     * @param bool $withType optional
     * @return mixed
     * @access public
     */
    public function getDNProp($propName, $dn = null, $withType = false)
    {
        if (!isset($dn)) {
            $dn = $this->dn;
        }

        if (empty($dn)) {
            return false;
        }

        if (($propName = $this->translateDNProp($propName)) === false) {
            return false;
        }

        $filters = [];
        $filters['value'] = ['type' => ASN1::TYPE_UT