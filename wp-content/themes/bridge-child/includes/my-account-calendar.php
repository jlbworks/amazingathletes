<?php
$locations = get_posts(
    array(
        'post_type'         => 'location',
        'post_status'       => 'any',
        'posts_per_page'    => -1,
        'author'            => $user->ID,
    )
);

$_locations = array();
$locations_for_calendar = array();

foreach ($locations as $l) {

    $locations_for_calendar[$l->ID] = array(
        'post_title' =>  $l->post_title,
    );
    $_locations[$l->ID] = $l->ID;
}

$coaches = get_users(array(
    'role'          => 'coach',
    'meta_key'      => 'franchisee',
    'meta_value'    => $user->ID,
));

$args = array(
    'post_type'         => 'location_class',
    'post_status'       => 'any',
    'posts_per_page'    => -1,
    'meta_query'        => array(
        array(
            'key'       => 'location_id',
            'value'     => array_values($_locations),
            'compare'   => 'IN',
        )
    )
);

$classes = get_posts($args);
$classes_for_calendar = [];

foreach ($classes as $c) {
    if (!$c->date) {
        continue;
    }

    //$title = "{$locations_for_calendar[$c->location_id]['post_title']} - {$c->type}";
    $title = "{$c->type}";
    $classes_for_calendar[] = array(
        'title' => $title,
        'start' => date('Y-m-d', strtotime("{$c->date} {$c->time}")),
    );
}
//exit();
?>
<div class="kolona1">
    <label>Location:</label>
    <select id="filter_location" name="location_id">
    <?php foreach ($locations as $l): ?>
        <option value="<?php echo $l->ID; ?>"><?php echo $l->post_title; ?></option>
    <?php endforeach; ?>
    </select>

    <label>Month:</label>
    <select id="filter_location" name="location_id">
    <?php for ($m=1; $m<=12; $m++): $month_name = date('F', mktime(0,0,0,$m, 1, date('Y'))); ?>
        <option value="<?php echo $m; ?>"><?php echo $month_name; ?></option>
    <?php endfor; ?>
    </select>

    <label>Coach:</label>
    <select id="filter_coach" name="coach_id">
    <?php foreach ($coaches as $c): ?>
        <option value="<?php echo $c->ID; ?>"><?php echo "{$c->first_name} {$c->last_name}"; ?></option>
    <?php endforeach; ?>
    </select>
</div>

<div style="margin-bottom:25px;"></div>

<div class="kolona1">
    <div id="calendar"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        events: <?php echo json_encode($classes_for_calendar); ?>,
        //defaultDate: '2016-06-12',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
    });

});
</script>
