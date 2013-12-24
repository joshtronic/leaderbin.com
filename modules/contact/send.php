<?php

class contact_send extends contact
{
	public function __default()
	{
		if (API_AYAH::isHuman())
		{
			// Sends the message
			mail('support@gravityblvd.com', '[LeaderBin] ' . $_POST['subject'], $_POST['email'] . "\n\n" . $_POST['message']);
			Browser::redirect('/contact?success');
		}
		else
		{
			?>
			<h1>Our system has determined that you may not be a human being.</h1>
			<p>If you happen to be Lil Wayne please <a href="/contact">contact us</a> as we’d love to hear about how you’re using our service.</p>
			<p>If you are not Lil Wayne, please <a href="/contact">go back</a> and try the challenge game again.</p>
			<iframe width="560" height="315" src="//www.youtube.com/embed/daRhEOkUL1o" frameborder="0" allowfullscreen></iframe>
			<?php
			exit;
		}
	}
}

?>
