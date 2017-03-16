<?php 
global $current_user; 
global $wpdb;
global $target_args;
get_currentuserinfo();

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query);

// Pagination
$items_per_page = 100;
$page = $target_args['page'] ? $target_args['page'] : 1;
$where = "1 = 1";
$s = $target_args['s'] ? $target_args['s'] : "";
if($s != "") {
	$where .= " AND city LIKE '%".$s."%'";
}
$offset = ( $page * $items_per_page ) - $items_per_page;
$total = $wpdb->get_var('SELECT COUNT(1) from zips');

restrict_access('administrator,franchisee,coach,super_admin');


$cities = $wpdb->get_results('SELECT * from zips WHERE '.$where.'  ORDER BY city ASC LIMIT 100 OFFSET '.$offset);


?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Cities</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','cities-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Cities Entry</button>
	            <input type="text" value="<?php echo ($target_args['s'] != "") ? $target_args['s'] : ''; ?>" name="s" class="form-control" placeholder="Search" id="search">
                <button class="btn btn--primary search">Search</button>
            </div>
        </div>
    </div>

    <table class="table js-responsive-table" id="datatable-editable">
                  <thead>
                    <tr>
                        <th data-colid="0">City</th>
                        <th data-colid="1">ZIP</th>                                                
                        <th data-colid="2">State</th>
                        <th data-colid="3">Lat</th>
                        <th data-colid="4">Lon</th>
                        <th data-colid="5">Review</th>
                        <th data-colid="6">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=0;
                    foreach($cities as $city){
                        echo "<tr>";
                        echo "<td>".$city->city."</td>";
                        echo "<td>".$city->zip."</td>";
                        echo "<td>".$city->state."</td>";
                        echo "<td>".$city->lat."</td>";
                        echo "<td>".$city->lng."</td>";
                        echo "<td>".$city->review."</td>";
                    ?>
                    <td>
                        <a class="am2-ajax-modal btn btn--primary is-smaller"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','cities-edit') .'&id='.$city->id_city; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') || is_role('super_admin') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="city" data-id="<?php echo $city->id_city; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </td>
                    <?php
                        echo "</tr>";   
                    } ?>
                </tbody>
                <tfoot class="pagination custom-pagination">
                <tr>
                    <td colspan="7">
                        <?php
                            echo paginate_links( array(
                                'base' => get_home_url().'/amp/#cities/?page=%#%',
                                'format' => '',
                                'prev_text' => __('&laquo;'),
                                'next_text' => __('&raquo;'),
                                'total' => ceil($total / $items_per_page),
                                'current' => $page
                            ));
                        ?>   
                    </td>
                </tr>
                </tfoot>
            </table>

<script type="text/javascript">

set_title('Cities');


$(document).ready(function() {


	function runQuery(){
		window.location.href = '#cities/?s='+$('input[name="s"]').val();
		return false;
	}

	$(".search").on('click',runQuery);

});
</script>

</script>

<?php get_template_part('blocks/modal-template'); ?>