<section id="feature" class="feature d-flex align-item-center">
    <div class="container-fluid h-100">
        <div class="row h-100 g-5">
            <?php
            // Assuming $fields contains all the fields fetched by get_fields()
            $fields = get_fields();

            // Check if homepage field and specific sub-array exist
            if (isset($fields['main'][1])) {
                $homepage_features = $fields['main'][1];

                // Loop through the features, assuming there are always 6 features as per your array
                for ($i = 1; $i <= 6; $i++) {
                    $img_field = 'img_feature_' . $i; // Dynamically create image field name
                    $txt_field = 'txt_feature_' . $i; // Dynamically create text field name

                    if (isset($homepage_features[$img_field]) && isset($homepage_features[$txt_field])) {
                        echo '<div class="col-6 col-md-2 d-flex flex-column flex-md-row align-items-center">'
                            . '<img src="' . esc_url($homepage_features[$img_field]) . '" alt="Feature ' . $i . '" class="img-fluid flex-fill">'
                            . '<p class="flex-fill d-flex align-items-center mb-0">' . esc_html($homepage_features[$txt_field]) . '</p>'
                            . '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>
</section>