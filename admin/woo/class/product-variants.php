<?php
/**
* 
*/
class Product_Variants {

    public function generate_pagination_variants( $variations ){

        $variations_per_page = 100;

        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $start_index = ($current_page - 1) * $variations_per_page;

        $end_index = min($start_index + $variations_per_page, count($variations));

        // $html = '';

        $html .= "<tr class='table-heading'>";

        foreach ($variations as $variation_id) {

            $variation = wc_get_product($variation_id);

            // $variation_attr = $variation->get_variation_attributes();

            $variation_attr = $variation->get_attributes();

            foreach ($variation_attr as $attribute_name => $attribute_value) {

                $label   = wc_attribute_label( $attribute_name, $product );

                $attribute_id = wc_attribute_taxonomy_id_by_name($attribute_name); 

                $hidden = get_option( "wc_attribute_hide_attribute-$attribute_id" ,0);

                $class = '';

                if($hidden == 1){

                   $class ="hidden";

                }

                $add_class = '';

                if(strtolower($label) === 'model'){

                    $add_class = "style='width: max-content;'";

                }   

                $html .= "<th class='$class' $add_class >" . $label . "</th>";

                   

            }

            if(is_user_logged_in()){

                $html .= "<th>Price</th>";

                $html .= "<th>PDF File</th>";

            }

           

            // $html .= "<th>ID</th>";

            $html .= "<th>Applications</th>";

            break;

        }

        $html .= "</tr>";

    

        for ($i = $start_index; $i < $end_index; $i++) {

            $variation_id = $variations[$i];

            $variation = wc_get_product($variation_id);

            // $variation_attr = $variation->get_variation_attributes();

            $variation_attr = $variation->get_attributes();

    

            $html .= "<tr class='table-data'>";

            foreach ($variation_attr as $attribute_name => $attribute_value) {

                $attribute_id = wc_attribute_taxonomy_id_by_name($attribute_name); 

                $hidden = get_option( "wc_attribute_hide_attribute-$attribute_id" ,0);

                $class = '';



                // check if variation is hidden

                $showHideVariation = get_post_meta($variation_id, 'hide_variation', true);

                $variation_class = '';

                if($showHideVariation == 'yes'){

                    $variation_class .= "hidden";

                }

                // eof check if variation is hidden



                if($hidden == 1){

                   $class ="hidden";

                }

                $label   = wc_attribute_label( $attribute_name, $product );

               

                if(strpos($label, 'PCR') !== false || strpos(strtolower($label), 'bolt') !== false){

                    $attribute_value = str_replace('-', '.', $attribute_value);

                }

               

                if(strtolower($label) != 'model' && strtolower($label) != 'part number' ){

                    $attribute_value = str_replace('-', ' ', $attribute_value);

                }

              



              

                $html .= "<td class='$class $variation_class'>" . $attribute_value .  "</td>";

                // $html .= "<td class='$class'>" . $attribute_value .  "</td>";

            }

            

            $variation_price = $variation->get_price();

            if(is_user_logged_in()){



                $html .= "<td class='$variation_class'>" . wc_price($variation_price) . "</td>";

                $pdf = get_post_meta($variation_id, 'pdf_file', true);

          

                if(!empty($pdf)){

                    $html .= "<td  class='$variation_class'><a href='$pdf' target='_blank' style='color:blue; text-transform:capitalize;'>View</a></td>";

                }else{

                    $html .= "<td  class='$variation_class'></td>";

                }

               

            }

            $add_to_cart_url = $variation->add_to_cart_url();

            // $html .= "<td><a href='{$add_to_cart_url}' class='custom-add-to-cart-button'>Cart</a>$variation_id</td>";

            // $html .= "<td>$variation_id</td>";

           

          

            // Applications

            global $wpdb;

            $product_id = $variation_id;

            $query = $wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'product_id'",'%');

            $counter = 0;

            $applicationNames = "";



            $post_ids = $wpdb->get_col($query);

            foreach ($post_ids as $post_id) {

                $post = get_post($post_id);

                $meta = get_post_meta( $post_id, "product_id",true );

                $numbersArray = explode(',', $meta);

                foreach($numbersArray as $key => $value){

                    if($product_id == $value){

                        $counter++;

                        $applicationAbbreviation = get_post_meta($post->ID,'abbreviation',true);

                        $app_link = get_permalink( $post->ID );

                        $applicationNames .= "<a href=$app_link>";

                        if($counter > 1) {

                            $applicationNames .= ($applicationNames ? ', ' : '') . $applicationAbbreviation;

                        } else {

                            $applicationNames .= ($applicationNames ? '' : '') . $applicationAbbreviation;

                        }

                        $applicationNames .= "</a>";

                    }

                }

            }

            $html .= "<td  class='$variation_class'>";

            $html .= $applicationNames;

            $html .= "</td>";

            $html .= "</tr>";

        }



        $pagination = $this->pagination_html($variations,$variations_per_page, $current_page,);



        return ['html' => $html, 'pagination' => $pagination];

     }





     public function pagination_html($variations,$variations_per_page, $current_page){



        // Pagination links

        $pagination = '';

        $total_pages = ceil(count($variations) / $variations_per_page);



        if ($total_pages > 1) {

            $pagination .= "<div class='pagination-row'><div class='flex'>";

            $start_page = max(1, min($current_page - 2, $total_pages - 4));

            $end_page = min($total_pages, max($current_page + 2, 5));

        

      

        if ($current_page > 1) {

            $prev_page = $current_page - 1;

            $pagination .= "<a href='?page={$prev_page}' class='prev'>Prev</a> ";

        }

  

        for ($page = $start_page; $page <= $end_page; $page++) {

            if ($page == $current_page) {

                $pagination .= "<a href='?page={$page}' class='page-$page current page-numbers'>{$page}</a> ";

            } else {

                $pagination .= "<a href='?page={$page}' class='page-{$page} page-numbers'>{$page}</a> ";

            }

        }

    

        if ($current_page < $total_pages) {

            $next_page = $current_page + 1;

            $pagination .= "<a href='?page={$next_page}' class='next'>Next</a> ";

        }

    

            $pagination .= "</div></div>";

        }



        return $pagination;

     }

}