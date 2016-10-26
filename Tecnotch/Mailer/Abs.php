<?php
/**
* 
*/
namespace Tecnotch\Mailer;

abstract class Abs implements I
{
	
	public $to = array();
	public $replyTo = array();
	
	public $from = array();
	public $cc = array();
	public $bcc = array();

	public $template;
	public $templatePath;
	public $placeholders = array();
	public $body;

	public $attachments;
	
	public $subject;
	
	abstract function send();
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	public function getSubject()
	{
		return trim($this->subject);
	}
		
	public function setTemplate($template)
	{
    	$this->template = $template;
    	
    	$this->parseTemplate();
 		
		return $this;
	}

	public function getTemplate()
	{
		return $this->template;
	}
	
	public function setTo(array $to)
	{
		$this->to = $to;
		return $this;
	}

	public function getTo()
	{
		return $this->to;
	}
 	
 	public function setReplyTo(array $replyTo)
	{
		$this->replyTo = $replyTo;
		return $this;
	}

	public function getReplyTo()
	{
		return $this->replyTo;
	}
 	
 	public function setFrom(array $from)
 	{
 		 
 		$this->from = $from;
 		return $this;
 	} 	
 	
 	public function getFrom()
 	{
 		return $this->from;
 	} 	
 	
 	public function setPlaceholders(array $placeholders)
 	{
 		$this->placeholders = $placeholders;
 		return $this;
 	}

 	public function getPlaceholders()
 	{
 		return $this->placeholders;
 	}
 	
 	public function setCc(array $email) 
 	{
		$this->cc = $email;
		return $this;
 	}
 	
 	public function getCc() 
 	{
		return $this->cc;
 	}
 	
 	public function setBcc(array $email) 
 	{
		$this->bcc = $email;
		return $this;
 	}
 	
 	public function getBcc() 
 	{
		return $this->bcc;
 	}
 	
 	public function setTemplatePath($path)
 	{
 		$this->templatePath = $path;
 		return $this;
 	}

 	public function getTemplatePath()
 	{
 		return $this->templatePath;
 	}

 	public function getTemplateContents()
 	{
 		if ($this->getTemplate()) {
 			return file_get_contents(rtrim($this->templatePath, '/') . '/' . $this->getTemplate());	
 		}
 		return false;
 	}
 	
 	public function parseTemplate()
 	{
 		if ($html = $this->getTemplateContents()) {

	 		
	 		$subject = preg_match('#\[Subject:([^\]]*)\]#i', $html, $match);
	 		
	 		if (!empty($match[1])) {
	 			$this->setSubject($match[1]);
	 		}
	 		
	 		$html = preg_replace('#(\[Subject:[^\]]*\])#', '', $html);
	 		
	 		$search = array_keys($this->placeholders);
	 		$replace = array_values($this->placeholders);
	 		$_html = str_replace($search, $replace, $html);	

	 		//echo "sub: " . $this->getSubject(); die;

	 		
	 		$this->setBody($_html);
 		}
 	}
 	
 	protected function _parseAttachmentType($type) 
 	{
 		switch ($type) {
 			case 'pdf':
 				return "application/pdf";
 				return "application/octet-stream";
 			break;

 			default:
 				return "text/html";
 			break;
 		}
 	}

 	public function addAttachment($filePath, $title=null, $type='pdf')
 	{
 		$parts = explode(DIRECTORY_SEPARATOR, $filePath);
       	$fileName  = array_pop($parts);

 		$attachment = array(
 				'file_path' => $filePath,
 				'file_name'	=> $fileName,
 				'title'		=> $title ? $title : $fileName,
 				'type'		=> $this->_parseAttachmentType($type)
 			);

 		$this->attachments[] = $attachment;
 		return $this;
 	}

 	public function setAttachments(array $attachments)
 	{
 		$this->attachments = $attachments;
 		return $this;
 	}

 	public function getAttachments()
 	{
 		return $this->attachments;
 	}

 	public function setBody($body) {
 		$this->body = $body;
 		return $this;
 	}

 	public function getBody()
 	{
 		return $this->body;
 	}

 	protected function _parseArgs()
	{
		$from 		= $this->getFrom();
		$to 		= $this->getTo();
		$cc 		= $this->getCc();
		$replyTo 	= $this->getReplyTo();


		$_from 		= current($from) . ' <' . key($from) . '>';
		
		if ($replyTo) {
			$_replyTo = current($replyTo) . " <". key($replyTo) . ">";

		} else {
			$_replyTo = current($from) . " <". key($from) . ">";
		}

		$_to = array();

		foreach ($to as $email => $name) {
			$_to[] = "{$name} <{$email}>";
		}

		$_tos = trim(implode(",", $_to));
		

		// parse cc
		$_cc = array();

		foreach ($cc as $email => $name) {
			$_cc[] = "{$name} <{$email}>";
		}

		$_cc = trim(implode(",", $_cc));

		//return array
		return array(
				$_tos,
				$_from,
				$_cc,
				$_replyTo
			);
	}

	public function reset()
	{
		$this->attachments = null;
	}
}
