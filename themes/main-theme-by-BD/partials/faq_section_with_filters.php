<?php if (get_sub_field('visible')) : ?><section id="main-faq" class="mardello_section main-faq py-5" style="background-color: #D5D5D533;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-sm-12 col-md-2">
                    <div class="main-faq__fitter">
                        <h1 class="main-faq__fitter__heading mb-4">Filtri</h1>
                        <div class="form-check"><input type="radio" id="group-0" class="form-check-input me-3" name="filter">
                                <label class="form-label form-label form-check-label" for="group-0">Mostra tutti</label>
                        </div>
                        <?php if( have_rows('content_repeater') ): ?>
                            <?php $g = 1; while( have_rows('content_repeater') ): the_row(); 
                                // Get sub field values.
                                $group = get_sub_field('group');
                                ?>
                                <div class="form-check"><input type="radio" id="group-<?php echo $g;?>" class="form-check-input me-3" name="filter">
                                <label class="form-label form-label form-check-label" for="group-<?php echo $g;?>"><?php echo $group['category'];?></label>
                            </div>
                            
                        
                            <?php $g++; endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-10">
                    <div id="main-faq__accordion">
                        <div class="accordion" role="tablist" id="accordion-1">
                        <?php if( have_rows('content_repeater') ): ?>
                            <?php $g=1; while( have_rows('content_repeater') ): the_row(); 
                        
                                // Get sub field values.
                                $group = get_sub_field('group');
                        
                                ?>
                                <?php  foreach($group['content_repeater'] as $key=>$qa) :?>
                                    <?php $a = rand(1,1000);?>
                                    <div class="accordion-item" data-id="group-<?php echo $g;?>">
                                <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed py-5" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-<?php echo $a;?>" aria-expanded="true" aria-controls="accordion-1 .item-<?php echo $a;?>">
                                    <?php echo $qa['question'];?>
                                </button></h2>
                                <div class="accordion-collapse collapse item-<?php echo $a;?> " role="tabpanel" data-bs-parent="#accordion-1">
                                    <div class="accordion-body">
                                        <div class="main-faq__content__paragraph mb-0">
                                        <?php echo $qa['answer'];?>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            <?php  endforeach;?>            
                            <?php $g++; endwhile; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        jQuery(document).ready(function(){
        var $ = jQuery;
        $(".main-faq__fitter :input").click(function() {
            var id = $(this).attr('id');
            console.log(id);
            $(".accordion-item").hide();
            $(".accordion-item[data-id='"+id+"'").show();
            if (id == 'group-0') {
            $(".accordion-item").show();

            }
        });
        });
    </script>
            <?php endif; ?>