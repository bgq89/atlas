<div class="info"
	<?php
		if ((!isset($_SESSION['msg_info']))||($_SESSION['msg_info']=='')) {
			echo 'style="display:none;">';
		}
		else {
			echo '>&#128712;&nbsp;' . $_SESSION['msg_info'];
		}
	?>
</div>
<div class="exito"
	<?php
		if ((!isset($_SESSION['msg_exito']))||($_SESSION['msg_exito']=='')) {
			echo 'style="display:none;"';
			echo '>';
		}
		else {
			echo '>';
			echo '&#10004;&nbsp;' . $_SESSION['msg_exito'];
		}
	?>
</div>
<div class="aviso"
	<?php
		if ((!isset($_SESSION['msg_aviso']))||($_SESSION['msg_aviso']=='')) {
			echo 'style="display:none;"';
			echo '>';
		}
		else {
			echo '>';
			echo '&#9888;&nbsp;' . $_SESSION['msg_aviso'];
		}
	?>
</div>
<div class="error"
	<?php
		if ((!isset($_SESSION['msg_error']))||($_SESSION['msg_error']=='')) {
			echo 'style="display:none;"';
			echo '>';
		}
		else {
			echo '>';
			echo '&#10008;&nbsp;' . $_SESSION['msg_error'];
		}
	?>
</div>
<div class="valida"
	<?php
		if ((!isset($_SESSION['msg_valida']))||($_SESSION['msg_valida']=='')) {
			echo 'style="display:none;"';
			echo '>';
		}
		else {
			echo '>';
			echo '&#8263;&nbsp;' . $_SESSION['msg_valida'];
		}
	?>
</div>