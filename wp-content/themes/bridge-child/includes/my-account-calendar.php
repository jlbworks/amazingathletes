<style type="text/css">
.fc-time{
   display : none;
}
</style>

<?php
$author_id = (int) get_query_var('author');
if (!empty($author_id)) {
    $user = get_user_by('ID', (int) $author_id);
}

require('When/Valid.php');
require('When/When.php');

function stringToColorCode($str) {
    $code = dechex(crc32($str));
    $code = substr($code, 0, 6);
    return "#{$code}";

}

function am2_get_occurrences($_class) {
    $r = new When\When();

    if (date('l') == $_class->day) {
        $r->startDate(new DateTime(date('Y-m-d')));
    } else {
        $r->startDate(new DateTime(date('Y-m-d', strtotime("next {$_class->day}"))));
    }

    $r->count(365);

    if ('Weekly' === $_class->schedule_type) {
        $r->byday(substr($_class->day, 0, 2));
        $r->freq('weekly');
    }

    if ('Monthly' == $_class->schedule_type) {
        $r->startDate(new DateTime(date('Y-m-d', strtotime("{$_class->monthly_every} {$_class->day} of this month"))));
        $r->byday(substr($_class->day, 0, 2));
        $r->count(365);
        $r->freq('monthly');
        //$r->bymonthday(1);
    }

    if ('Yearly' == $_class->schedule_type) {
        $this_year = date('Y');
        $r->startDate(new DateTime(date("{$this_year}-m-d", strtotime("{$_class->date_every_year}"))));
        //$r->bymonthday(date('d', strtotime("{$_class->day}")));
        $r->count(10);
        $r->freq('yearly');
    }

    $r->generateOccurrences();

    return $r->occurrences;
}

function am2_format_event_for_calendar($_class, $data=array()) {
    $title = "{$_class->program}";

    if ($_class->date) {
        $start = date('Y-m-d', strtotime("{$_class->date}"));
        $end = $start;
    }

    if (isset($data['start'])) {
        $start = $data['start'];
        $end = $data['start'];
    }

    if (isset($data['end'])) {
        $end = $data['end'];
    }

    $color = '#87CEFA';

    if (is_array($_class->coaches) and !empty($_class->coaches)) {

        $coach = get_user_by('ID', (int) $_class->coaches[0]);

        $color = stringToColorCode("{$coach->first_name} {$coach->last_name}");
    }

    return array(
        'title' => $title,
        'start' => $start,
        'end'   => $end,
        'backgroundColor'   => $color,
        'borderColor'       => $color,
    );
}

$locations = get_posts(
    array(
        'post_type'         => 'location',
        'post_status'       => 'any',
        'posts_per_page'    => -1,
        'author'            => $user->ID,
    )
);

$_locations             = array();
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

$lid = false;

if (isset($_GET['location_id']) and !empty($_GET['location_id'])) {
    $lid = (int) $_GET['location_id'];
    $_locations = array();
    $_locations[$lid] = $lid;
}

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

$cid = false;

foreach ($classes as $c) {
    //var_dump(get_post_meta($c->ID));
    if (isset($_GET['coach_id']) and !empty($_GET['coach_id'])) {
        $cid = (int) $_GET['coach_id'];
        if(!is_array($c->coaches) or !in_array($cid, $c->coaches)) {
            continue;
        }
    }

    if (in_array($c->type, array('Parent-Pay', 'Contract'))) {

        $occurrences = am2_get_occurrences($c);

        foreach ($occurrences as $o) {

            $classes_for_calendar[] = am2_format_event_for_calendar($c, array('start' => $o->format('Y-m-d')));
        }

        continue;
    }

    if ('Session' === $c->type and (!empty($c->date_start) and !empty($c->date_end))) {
        $classes_for_calendar[] = am2_format_event_for_calendar($c, array('start' => $c->date_start, 'end' => $c->date_end));
        continue;
    }

    if (!$c->date) {
        continue;
    }

    $classes_for_calendar[] = am2_format_event_for_calendar($c);
}
//exit();
?>
<div class="kolona1">
    <form method="get">
        <label>Location:</label>
        <select id="filter_location" name="location_id">
            <option></option>
        <?php foreach ($locations as $l): ?>
            <option value="<?php echo $l->ID; ?>" <?php if ($lid==$l->ID): ?> selected="selected" <?php endif;?> ><?php echo $l->post_title; ?></option>
        <?php endforeach; ?>
        </select>

        <!--<label>Month:</label>
        <select id="filter_location" name="location_id">
            <option></option>
        <?php for ($m=1; $m<=12; $m++): $month_name = date('F', mktime(0,0,0,$m, 1, date('Y'))); ?>
            <option value="<?php echo $m; ?>"><?php echo $month_name; ?></option>
        <?php endfor; ?>
        </select>-->

        <label>Coach:</label>
        <select id="filter_coach" name="coach_id">
            <option></option>
        <?php foreach ($coaches as $c): ?>
            <option value="<?php echo $c->ID; ?>" <?php if ($cid==$c->ID): ?> selected="selected" <?php endif;?>><?php echo "{$c->first_name} {$c->last_name}"; ?></option>
        <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>
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
