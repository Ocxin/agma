<div class="paragraph col-12 offset-0 col-md-8 offset-md-2">
    <?php
    $sample_content = get_sub_field('sample_content');  // Ottiene il valore del sotto campo 'sample_content' per il post specificato.

    // Assicurati che il contenuto non sia vuoto prima di stamparlo.
    if (!empty($sample_content)) {
        echo ($sample_content);  // Stampa il contenuto del campo.
    } else {
        echo '<p>Nessun contenuto disponibile.</p>';  // Fornisce un messaggio fallback nel caso il campo sia vuoto.
    }
    ?>
</div>
