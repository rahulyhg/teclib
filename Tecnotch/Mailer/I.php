<?php
namespace Tecnotch\Mailer;

interface I {
	/*
		$params = array(
				'from' => array(
						'email' => 'name',
					),
				'Subject'	=> $subject,
				'to'	=> array(
						'tofeeq3@gmail.com' => 'Tofeeq'
					),
				'cc'	=> array(
						'tofeeq3@gmail.com' 
					),
				'body'	=> $body
			);
	*/
	public function setSubject($subject);
	public function getSubject();

	public function setFrom(array $from);
	public function getFrom();

	public function setTo(array $to);
	public function getTo();

	public function setReplyTo(array $replyTo);
	public function getReplyTo();

	public function setCc(array $cc);
	public function getCc();

	public function setBcc(array $bcc);
	public function getBcc();

	public function setTemplatePath($path);
	public function getTemplatePath();

	public function setTemplate($template);
	public function getTemplate();

	public function setPlaceholders(array $placeholders);
	public function getPlaceholders();

	public function setBody($body);
	public function getBody();

	public function setAttachments(array $attachments);
	public function getAttachments();

	public function send();

	public function reset();
}
