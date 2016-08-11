<?php

if( is_role('client') ){
  include(dirname(__FILE__).'/bolnica-dashboard.php');
  exit();
}


$args = array(
  'post_type'   => 'bolnice',
  'post_status' => 'publish',
  'posts_per_page'=>-1
);
$ukupno_bolnica = count(get_posts($args));


$args = array(
  'post_type'   => 'podaci',
  'post_status' => 'publish',
  'posts_per_page'=>-1
);
$ukupno_podataka = count(get_posts($args));


$args = array(
  'post_type'   => 'pacijenti',
  'post_status' => 'publish',
  'posts_per_page'=>-1
);
$total_pacijenti = count(get_posts($args));


$total_users = count(get_users());


?>
    
<div class="layout">
    <div class="container clearfix">
        <div class="col-12 break-big">
            <div class="card-wrapper">
                <h3 class="card-header">Informacije</h3>
                <div class="card-inner">
                    <div class="card-table">

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Ukupno Bolnica</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                <fieldset>
                                <?php echo $ukupno_bolnica; ?>
                                <a class="text-muted text-uppercase" href="#bolnice">(view all)</a>
                                </fieldset>
                                </form>
                            </div>
                        </div>

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Ukupno Doktora</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                <fieldset>
                                <?php echo $total_users; ?>
                                <a class="text-muted text-uppercase" href="#users-management">(view all)</a>
                                </fieldset>
                                </form>
                            </div>
                        </div>

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Ukupno Pacijenata</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                <fieldset>
                                <?php echo $total_pacijenti; ?>
                                <a class="text-muted text-uppercase" href="#pacijenti">(view all)</a>
                                </fieldset>
                                </form>
                            </div>
                        </div>

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Ukupno Podataka</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                <fieldset>
                                <?php echo $ukupno_podataka; ?>
                                <a class="text-muted text-uppercase" href="#podaci">(view all)</a>
                                </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  set_title('Dashboard');
</script>