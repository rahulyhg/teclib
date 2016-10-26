<?php 
/**
* 
*/
namespace Tecnotch\Mailer;

class Simple extends Abs
{
	
	public function send() {

		list($to, $from, $cc, $replyTo) = $this->_parseArgs();
		 
		/* sending attachments within mail */
		$attachments = $this->getAttachments();

		if (!empty($attachments)) {
			$res = $this->_sendAttachment(
				$to, $from, $attachments, $replyTo, $cc
			);
			
			\Tecnotch\Logger::rlog($res);
		
			return $res;
		}

		/* 
			Sending simple email without attacments
		*/

		$res = $this->_sendSimple(
			$to, $from, $replyTo, $cc
		);
		
		\Tecnotch\Logger::rlog($res);
	
		return $res;
	}

	/* technical part */
	private function _sendSimple($to, $from, $replyTo = null, $cc = null)
	{
		$headers = "From: {$from}\n";

		if ($replyTo) {
			$headers .= "Reply-To: {$replyTo}\n";
		}

		if ($cc) {
			$headers .= "CC: {$cc}\n";	
		}

		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset=utf-8\n";
		
		$res = mail($to, $this->getSubject(), $this->getBody(), $headers);	
		
		return $res;
	}


	private function _sendAttachment($to, $from, $attachments, $replyTo = null, $cc = null)
    {
        
        $subject = $this->getSubject(); 
	    $message = $this->getBody();
	    $headers = "From: $from";

        if ($cc) {
        	$headers .= "\nCc: {$cc}";
    	}

    	if ($replyTo) {
    		$headers .= "\nReply-To: {$replyTo}";
    	}

    	// boundary 
		
		$mimeBoundary = "==" . md5(time()); 

		// headers for attachment 
		$headers .= "\nMIME-Version: 1.0\n" 
				. "Content-Type: multipart/mixed;\n" 
				. " boundary=\"{$mimeBoundary}\""; 

		// multipart boundary 
		$message = "This is a multi-part message in MIME format.\n\n" 
				. "--{$mimeBoundary}\n" 
				. "Content-Type: text/html; charset=\"iso-8859-1\"\n" 
				. "Content-Transfer-Encoding: 7bit\n\n" 
				. $message 
				. "\n\n"; 

		$message .= "--{$mimeBoundary}";

		// preparing attachments
		foreach ($attachments as $attachment) {
			$filePath = $attachment['file_path'];
			$fileName  = $attachment['file_name'];
			$fileType  = $attachment['type'];
       		$fileTitle = $attachment['title'];

       		$file = fopen($filePath,"rb");
	        $fileData = fread($file, filesize($filePath));
	        fclose($file);

       		 
       		
       		

		    $data = chunk_split(base64_encode($fileData));
		    //set name as fileName because thunderbird doesn't support titles without extension
		    $message .= "\nContent-Type: {$fileType};\n" 
		    	. " name={$fileTitle}\n" 
		    	. "Content-Disposition: attachment;\n" 
		    	. " filename=\"{$fileName}\"\n" 
		    	. "Content-Transfer-Encoding: base64\n\n" 
		    	. trim($data)
		    	. "\n--{$mimeBoundary}";
		}

        $res = mail($to, $subject, $message, $headers);
        
        return $res;
        
    }

}