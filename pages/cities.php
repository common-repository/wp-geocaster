<?php
$page= $this->config['action'];
$config= array('page'=>'cities');
$country = new WPGEOC_Tables($config);
$country->prepare_items();
switch($page){
    case 'add':
    case 'edit':?>
        <div class="wrap">
        <form class="wrap" name="cities" id="cities" method="post" action="">
            <div id="linkadvanceddiv">
                <div style="float: left; width: 100%; clear: both;" class="inside">
                    <table cellpadding="5" cellspacing="5">
                        <tr rowspan=2>
                            <td><h2><?php echo ($this->config['data']->id)? _e('Edit City','wp_geocaster'):  _e('New City','wp_geocaster');?></h2></td>
                        </tr>
                        <tr>
                            <td><?php _e('Country','wp_geocaster'); ?></td>
                            <td>
                            <select name="country_id" id="country_id">
                                <?php
                                if($this->config['countries']){
                                foreach($this->config['countries'] as $country){?>
                                <option value="<?php echo $country->id;?>" <?php if($country->id ==$this->config['data']->country_id) echo " selected";?> ) ><?php echo $country->name;?></option>
                                <?php }
                                }?>
                            </select>
                            </td>
                           </tr>

                        <tr>
                            <td><?php _e('State','wp_geocaster'); ?></td>
                            <td>
                                <input type="text" name="state" class="input" size="54"
                                       maxlength="200" value="<?php echo $this->config['data']->state;?>"/>
                            </td>
                            </td>
                        </tr>

                        <tr>
                            <td><?php _e('City','wp_geocaster'); ?></td>
                            <td>
                                <input type="text" name="name" class="input" size="54"
                                       maxlength="200" value="<?php echo $this->config['data']->name;?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td><?php _e('Url','wp_geocaster'); ?></td>
                            <td>
                                <input type="text" name="url" class="input" size="54"
                                       maxlength="200" value="<?php echo $this->config['data']->url;?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td><?php _e('Published','wp_geocaster');?></td>
                            <td>
                                <input type="radio" name="published" value="1" <?php if($this->config['data']->published==1) echo "checked";?> > <?php _e('Yes','wp_geocaster');?>&nbsp;&nbsp;
                                <input type="radio" name="published" value="0" <?php if($this->config['data']->published==0) echo "checked";?>> <?php _e('No','wp_geocaster');?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="save" class="button button-primary" value="<?php _e('Save', 'wp_geocaster'); ?> &raquo;"/>
                                <input type="hidden" name="action" value="save" />
                                <input type="hidden" name="id" value="<?php echo $this->config['data']->id;?>" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        </div><?php
        break;
    case 'display':
    default:?>
        <div class="wrap">
            <div id="icon-users" class="icon32"><br/></div>
            <h2><?php _e('Cities','wp_geocaster');?> <a class="add-new-h2" href="?page=wpgeoc-cities&action=new"><?php _e('Add New City','wp_geocaster');?></a></h2>
            <form id="cities" name="cities" method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <?php $country->display();?>
            </form>
        </div>
        <?php
        break;}?>