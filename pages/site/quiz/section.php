<div class="pre-content"></div>
<div class="quiz">
<h1><?php echo $_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['name']; ?></h1>

<?php if ( isset($_SESSION['wpsqt']['current_message']) ) { ?>
	<p class="quizNotice"><?php echo $_SESSION['wpsqt']['current_message']; ?></p>
<?php } ?>

<?php /*script type="text/javascript" src="<?php echo plugins_url( 'wp-survey-and-quiz-tool/js/quickpager.jquery.js'); ?>"></script>

<script type="text/javascript">
jQuery(document).ready(function( ) {
	jQuery("div#sectionQuestions").quickPager({pageSize:5, childSelector:'div.wpst_question'});
	jQuery(window).bind('beforeunload', function(){
		return 'Are you sure you want to abandon this quiz?';
	});
	jQuery("#sectionForm").submit(function(){
		window.onbeforeunload = null;
	});
});
</script */ ?>

<script type="text/javascript">
jQuery(document).ready(function( ) {
	jQuery(window).bind('beforeunload', function(){
		return 'Are you sure you want to abandon this quiz?';
	});
	jQuery("#sectionForm").submit(function(){
		window.onbeforeunload = null;
	});
});
</script>

<form id="sectionForm" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<input type="hidden" name="step" value="<?php echo ( $_SESSION['wpsqt']['current_step']+1); ?>">
	<div id="sectionQuestions" >
<?php
		$answers = ( isset($_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"]) ) ? $_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"] : array();
foreach ($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'] as $questionKey => $question) { ?>

	<div class="wpst_question">
		<?php 
		
			$questionId = $question['id'];		
			$givenAnswer = isset($answers[$questionId]['given']) ? $answers[$questionId]['given'] : array();
			
			if ( isset($question["required"]) &&  $question["required"] == "yes" ){ 
				?>
				<font color="#FF0000"><strong>*
				
			<?php			
				// See if the question has been missed and this a replay if not end the red text here.
				if ( empty($_SESSION['wpsqt']['current_message']) || in_array($questionId,$_SESSION['wpsqt']['required']['given']) ){
					?></strong></font><?php 
				}
			}			
						
			echo stripslashes($question['name']);
			
			// See if the question has been missed and this is a replay
			if ( !empty($_SESSION['wpsqt']['current_message']) && !in_array($questionId,$_SESSION['wpsqt']['required']['given']) ){
				?></strong></font><?php 
			}	

			if ( !empty($question['add_text']) ){
			?>
			<p><?php echo nl2br(stripslashes($question['add_text'])); ?></p>
			<?php } ?>
			
			<?php if ( isset($question['image']) && !empty($question['image'])) { ?>
			<p><?php echo stripslashes($question['image']); ?></p>
			<?php } ?>
			
			<?php do_action('wpsqt_quiz_question_section',$question); ?>
			
			<?php require Wpsqt_Question::getDisplayView($question); ?>
			
	</div>
<?php } ?>
	</div>
	<?php
	if ($sectionKey == (count($_SESSION['wpsqt'][$quizName]['sections']) - 1)) {
	?><div style="text-align:center"><input type='submit' value='Submit' class='button-secondary' /></li></div><?php
} else {
	?><div style="text-align:center"><input type='submit' value='Next &raquo;' class='button-secondary' /></div><?php
}
?>
	
<div class="quizSectionNav">
<?php
$t = $sectionKey +1;
foreach (range(1,count($_SESSION['wpsqt'][$quizName]['sections'])) as $s) {
	echo '<span class="'.( ($t > $s ) ? 'quizSectionNavDone' : ( ($t == $s ) ? 'quizSectionNavDoing' : 'quizSectionNavTodo' ) ).'">'.$s.'</span>';
}
?>
</div>

	
</form>
</div>
<div class="post-content"></div>