<?php
$page= $this->config['action'];
$config= array('page'=>'countries');
$country = new WPGEOC_Tables($config);
$country->prepare_items();
switch($page){
    case 'add':
    case 'edit':?>
<div class="wrap">
<form class="wrap" name="countries" id="countries" method="post" action="">
    <div id="linkadvanceddiv">
        <div style="float: left; width: 100%; clear: both;" class="inside">
            <table cellpadding="5" cellspacing="5">
                <tr rowspan=2>
                    <td><h2><?php echo ($this->config['data']->id)? _e('Edit Country','wp_geocaster'):  _e('New Country','wp_geocaster');?></h2></td>
                </tr>
                <tr>
                    <td><?php _e('Title','wp_geocaster'); ?></td>
                    <td>
                        <input type="text" name="name" class="input" size="54"
                               maxlength="200" value="<?php echo $this->config['data']->name;?>"/>
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
    <h2><?php _e('Countries','wp_geocaster');?> <a class="add-new-h2" href="?page=wpgeoc-countries&action=new"><?php _e('Add New Country','wp_geocaster');?></a></h2>
    <form id="countries" name="countries" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $country->display();?>
    </form>
</div>
<?php
    break;}?>