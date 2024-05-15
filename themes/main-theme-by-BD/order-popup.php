<div class="modal fade" role="dialog" tabindex="-1" id="orderModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <section class="purchase-phases py-5 px-4">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-12 col-md-10 col-lg-8">
                                    <div class="purchase-phases__progress mb-5">
                                        <h1 id="phase" class="purchase-phases__progress__heading">Fase 1 di 2</h1>
                                        <div class="progress purchase-phases__progress__bar">
                                            <div class="progress-bar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress-bar" style="width:50%;">50%</div>
                                        </div>
                                    </div>
                                    <div id="content" class="purchase-phases__content">
                                        <h1 class="purchase-phases__content__haeding mb-3">Preventivo</h1>
                                        <div class="purchase-phases__content__list">
                                            <div class="d-flex justify-content-between align-items-center purchase-phases__content__list__item">
                                                <div class="purchase-phases__content__list__item__paragraph">
                                                    <p><?php echo $title;?></p>
                                                </div>
                                                <div class="purchase-phases__content__list__item__paragraph">
                                                    <p id="popup_base_price"><?php echo $base_price;?></p>
                                                </div>
                                            </div>
                                            <div id="poup_addons">


                                            </div>
                                           
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center purchase-phases__content__total mt-3">
                                            <div class="purchase-phases__content__total__paragraph">
                                                <p>Subtotale</p>
                                            </div>
                                            <div class="purchase-phases__content__total__paragraph">
                                            <p>€<span id="subtotal_popup"><?php echo $base_price;?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none purchase-phases__form" id="form">
                                      <?php echo do_shortcode('[contact-form-7 id="914" title="Product Form"]');?>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center flex-wrap mt-4 purchase-phases__buttons" id="phaseButton1"><a class="purchase-phases__link me-5 dismiss_modal" role="button"  data-dismiss="modal" >ANNULLA</a><button class="btn btn-primary purchase-phases__btn" id="modifyPhases" type="button">PROSSIMO</button></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>