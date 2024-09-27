<?php
/** Product Accordion 
*
*@var $product  = product object
*/
global $product;
$variants = new Product_Variants();
$product = isset($product) ? $product : '';
$single_product = isset($single_product) ? $single_product : false;
$data_source = isset($data_source) ? $data_source : "";
$current_page_number = isset($_GET['page']) ? $_GET['page'] : 1;
$html = "";
$x = 0;
$pagination = "";
$current_product = $product->get_name();
$product_id = $product->get_id();
$featured_image_id = get_post_thumbnail_id($product_id);
$image = wp_get_attachment_image_src($featured_image_id, 'single-post-thumbnail');
$image_url = $image[0];
// Get the variations once
$variations = $product->get_children();
$html = $variants->generate_pagination_variants($variations);
// $pagination = $html['pagination'];
$html = $html['html'];
$pId = $product->get_id();

?>                                     
<section class="product-accordion">
    <div class="container">
        <div class="row">
            <div class="grid">
                <div class="item accordion">
                    <div class="heading">
                        <div class="_title">
                            <h1><?=$current_product;?></h1>
                        </div>
                        <div class="action" >
                            <!-- actions -->
                        </div>
                    </div>
                    <div class="accordion-content body flex ">
                        <div class="product-image _item test">
                            <!-- display product image -->
                        </div>
                        <div class="product-meta _item">
                            <table>
                                <tbody>
                                    <?=$html;?>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <!-- display pagination if needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



