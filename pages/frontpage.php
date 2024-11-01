<div class="wrap">
    <div class="sa_search">
        <form id="saform">
            <input type="tex" name="sa_search" id="sa_search" placeholder="Search city name" class="textbox"/>
            <input type="submit" name="sa_submit" id="sa_submit" value="Search">
            <?php if($this->config['access']){?><a href="#" id="sa_submit_city" class="button">Add your city</a><?php }?>
        </form>
    </div>
    <?php if($this->config['access']){?>	
    <div class="saCitryformwrapper">
        <form action="" method="post" name="frm_sa_city" id="frm_sa_city">
            <div class="sa_labelholder"><label for="sa_country">Country:</label></div>
            
            <div class="sa_inputholder"><select name="sa_country" id="sa_country">
                    <?php foreach($this->config['countries'] as $country){?>
                    <option value="<?php echo $country->id;?>"><?php echo $country->name;?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="sa_labelholder"><label for="sa_state">State:</label></div>
            
            <div class="sa_inputholder"><input type="tex" name="sa_state" id="sa_state" placeholder="Enter the state name"/></div>
            

            <div class="sa_labelholder"><label for="sa_city">City:</label></div>
            <div class="sa_inputholder"><input type="tex" name="sa_city" id="sa_city" placeholder="Enter the city name"/></div>
            

            <div class="sa_labelholder"><input type="submit" name="sa_city_submit" id="sa_city_submit" value="Save"></div>
            <div class="sa_inputholder"><input type="hidden" name="sa_action" value="save"></div>
         </form>

    </div>
<?php }?>
<div class="clear"></div>
    <div class="sa_country">
           <?php
                foreach( $this->config['items']  as $key=>$item)
                {
                    echo '<div class="sa_ctitle">'.$key.'</div>';
                    if( is_array($item)){						
                        echo ' <ul id="sa_citylist" class="sa-citylist">';
                        foreach($item as $i){
                           echo '<li>';
                            if($i->url){
                                $i->url = esc_url($i->url);
                                echo  '<a href="'.$i->url.'">'.$i->name;
                                if(!empty($i->state))
                                    echo ', '.$i->state;
                                    echo '</a>';
                            }else{
                                echo  '<span>'.$i->name;
                                if(!empty($i->state))
                                    echo ', '.$i->state;
                                    echo '</span>';
                            }
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
    </div>
</div>