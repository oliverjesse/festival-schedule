<?php

function festival_shortcode ( $atts ) {
    // Extract arguments and specify defaults
    extract(shortcode_atts(array(
        'day' => 'sunday'
    ), $atts));

    $stages = get_categories( array(
        'taxonomy' => 'stage',
        'hide_empty' => false,
        'meta_key' => 'order',
        'orderby' => 'meta_value_num'
    ) );
    $output = '';
	$output .= render_schedule_header($day);
	foreach ($stages as $stage) {
		$output .= render_events_for_stage( $stage, $day);
	}
	unset($stage);
//	var_dump($stages);
	$output .= render_schedule_footer();
    return $output;
}

add_shortcode('sfpride-timeline', 'festival_shortcode');


function render_schedule_header($day) {
	if ($day == 'saturday') {
		return render_saturday_header();
	} else {
		return render_sunday_header();
	}
}

function render_saturday_header() {
	return <<<EOF
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule-template/css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule-template/css/style.css"> <!-- Resource style -->
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule.css"> <!-- SF Pride Custom styles -->


<div class="cd-schedule loading">
	<div class="timeline">
		<ul>
			<li><span>12:00</span></li>
			<li><span>12:10</span></li>
			<li><span>12:20</span></li>
			<li><span>12:30</span></li>
			<li><span>12:40</span></li>
			<li><span>12:50</span></li>
			<li><span>13:00</span></li>
			<li><span>13:10</span></li>
			<li><span>13:20</span></li>
			<li><span>13:30</span></li>
			<li><span>13:40</span></li>
			<li><span>13:50</span></li>
			<li><span>14:00</span></li>
			<li><span>14:10</span></li>
			<li><span>14:20</span></li>
			<li><span>14:30</span></li>
			<li><span>14:40</span></li>
			<li><span>14:50</span></li>
			<li><span>15:00</span></li>
			<li><span>15:10</span></li>
			<li><span>15:20</span></li>
			<li><span>15:30</span></li>
			<li><span>15:40</span></li>
			<li><span>15:50</span></li>
			<li><span>16:00</span></li>
			<li><span>16:10</span></li>
			<li><span>16:20</span></li>
			<li><span>16:30</span></li>
			<li><span>16:40</span></li>
			<li><span>16:50</span></li>
			<li><span>17:00</span></li>
			<li><span>17:10</span></li>
			<li><span>17:20</span></li>
			<li><span>17:30</span></li>
			<li><span>17:40</span></li>
			<li><span>17:50</span></li>
			<li><span>18:00</span></li>
		</ul>
	</div> <!-- .timeline -->

	<div class="events saturday">
		<ul>
EOF;
}

function render_sunday_header() {
	return <<<EOF
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule-template/css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule-template/css/style.css"> <!-- Resource style -->
<link rel="stylesheet" href="/wp-content/plugins/event_festival/schedule.css"> <!-- SF Pride Custom styles -->


<div class="cd-schedule loading">
	<div class="timeline">
		<ul>
			<li><span>11:00</span></li>
			<li><span>11:10</span></li>
			<li><span>11:20</span></li>
			<li><span>11:30</span></li>
			<li><span>11:40</span></li>
			<li><span>11:50</span></li>
			<li><span>12:00</span></li>
			<li><span>12:10</span></li>
			<li><span>12:20</span></li>
			<li><span>12:30</span></li>
			<li><span>12:40</span></li>
			<li><span>12:50</span></li>
			<li><span>13:00</span></li>
			<li><span>13:10</span></li>
			<li><span>13:20</span></li>
			<li><span>13:30</span></li>
			<li><span>13:40</span></li>
			<li><span>13:50</span></li>
			<li><span>14:00</span></li>
			<li><span>14:10</span></li>
			<li><span>14:20</span></li>
			<li><span>14:30</span></li>
			<li><span>14:40</span></li>
			<li><span>14:50</span></li>
			<li><span>15:00</span></li>
			<li><span>15:10</span></li>
			<li><span>15:20</span></li>
			<li><span>15:30</span></li>
			<li><span>15:40</span></li>
			<li><span>15:50</span></li>
			<li><span>16:00</span></li>
			<li><span>16:10</span></li>
			<li><span>16:20</span></li>
			<li><span>16:30</span></li>
			<li><span>16:40</span></li>
			<li><span>16:50</span></li>
			<li><span>17:00</span></li>
			<li><span>17:10</span></li>
			<li><span>17:20</span></li>
			<li><span>17:30</span></li>
			<li><span>17:40</span></li>
			<li><span>17:50</span></li>
			<li><span>18:00</span></li>
		</ul>
	</div> <!-- .timeline -->

	<div class="events sunday">
		<ul>
EOF;
}

function render_events_for_stage( $stage, $day ) {
    $stage_output = "<li class='events-group'><div class='top-info'><span>" . $stage->name . "</span></div><ul>";
    // Reset and setup variables
    $this_title = '';
    $this_link = '';
    $this_start = '';
    $this_end = '';

    // Do query for this stage's events on this day
    $args = array(
    	'post_type' => 'performance',
    	'posts_per_page' => 20,
    	'stage' => $stage->name,
       	'meta_query' => array(
       		array(
       			'key' => 'day',
       			'value' => $day,
       		)
       	),
    );

	$events = query_posts( $args );
//	var_dump($events);

    // Loop over found events
    if (have_posts()) : while (have_posts()) : the_post();

        $this_title = get_the_title(get_the_ID());
        $this_start = get_post_meta(get_the_ID(), 'start_time', true);
        $this_end = get_post_meta(get_the_ID(), 'end_time', true);
        $this_genre = get_the_category(get_the_ID());
        $stage_output .= render_single_event($this_title, $this_genre, $this_start, $this_end);
    endwhile; else:
        $stage_output .= "";
    endif;
    wp_reset_query();

    $stage_output .= "</ul></li>";
    return $stage_output;
}

function render_single_event( $title, $genre, $start, $end ) {
//	var_dump($genre);
//	$genres = array_map( function($cat) { return $cat->slug; }, $genre);
//	var_dump($genres);
	$event = "<li class='single-event' data-genre='" . $genre[0]->slug . "' data-start='" . $start . "' data-end='" . $end . "'><a href='#0'>";
	$event .= "<em class='event-name'>" . $title . "</em></a></li>";
	return $event;
}

function render_schedule_footer() {
	return <<<EOF
</ul>
	</div>

	<div class="event-modal">
		<header class="header">
			<div class="content">
				<span class="event-date"></span>
				<h3 class="event-name"></h3>
			</div>

			<div class="header-bg"></div>
		</header>

		<div class="body">
			<div class="event-info"></div>
			<div class="body-bg"></div>
		</div>

		<a href="#0" class="close">Close</a>
	</div>

	<div class="cover-layer"></div>
</div> <!-- .cd-schedule -->
<script src="/wp-content/plugins/event_festival/schedule-template/js/modernizr.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script>
	if( !window.jQuery ) document.write('<script src="/wp-content/plugins/event_festival/schedule-template/js/jquery-3.0.0.min.js"><\/script>');
</script>
<script src="/wp-content/plugins/event_festival/schedule-template/js/main.js"></script>
EOF;
}


//			<li><span>13:00</span></li>
//			<li><span>13:00</span></li>
//			<li><span>13:15</span></li>
//			<li><span>13:30</span></li>
//			<li><span>13:45</span></li>
//			<li><span>14:00</span></li>
//			<li><span>14:15</span></li>
//			<li><span>14:30</span></li>
//			<li><span>14:45</span></li>
//			<li><span>15:00</span></li>
//			<li><span>15:15</span></li>
//			<li><span>15:30</span></li>
//			<li><span>15:45</span></li>
//			<li><span>16:00</span></li>
//			<li><span>16:15</span></li>
//			<li><span>16:30</span></li>
//			<li><span>16:45</span></li>
//			<li><span>17:00</span></li>
//			<li><span>17:15</span></li>
//			<li><span>17:30</span></li>
//			<li><span>17:45</span></li>
//			<li><span>18:00</span></li>