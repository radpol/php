<?php
class SimpleMail
{
  // Vlastnosti tøídy - položky zprávy.
  private $toAddress;
  private $CCAddress;
  private $BCCAddress;
  private $fromAddress;
  private $subject;
  private $sendText;
  private $textBody;
  private $sendHTML;
  private $HTMLBody;

  // Inicializace položek zprávy prázdnými nebo implicitními hodnotami.
  public function __construct() {
    $this->toAddress = '';
    $this->CCAddress = '';
    $this->BCCAddress = '';
    $this->fromAddress = '';
    $this->subject = '';
    $this->sendText = true;
    $this->textBody = '';
    $this->sendHTML = false;
    $this->HTMLBody = '';
  }

  // Nastavení adresy pøíjemce.
  public function setToAddress($value) {
    $this->toAddress = $value;
  }

  // Nastavení adresy pøíjemce kopie.
  public function setCCAddress($value) {
    $this->CCAddress = $value;
  }

  // Nastavení adresy pøíjemce skryté kopie.
  public function setBCCAddress($value) {
    $this->BCCAddress = $value;
  }

  // Nastavení adresy odesílatele.
  public function setFromAddress($value) {
    $this->fromAddress = $value;
  }

  // Nastavení pøedmìtu zprávy.
  public function setSubject($value) {
    $this->subject = $value;
  }

  // Nastavení, zda má být zpráva odeslána jako prostý text.
  public function setSendText($value) {
    $this->sendText = $value;
  }

  // Nastavení tìla textové zprávy.
  public function setTextBody($value) {
    $this->sendText = true;
    $this->textBody = $value;
  }

  // Nastavení, zda má být zpráva odeslána ve formátu HTML.
  public function setSendHTML($value) {
    $this->sendHTML = $value;
  }

  // Nastavení tìla zprávy ve formátu HTML.
  public function setHTMLBody($value) {
    $this->sendHTML = true;
    $this->HTMLBody = $value;
  }

  // Odeslání zprávy.
  public function send($to = null, $subject = null, $message = null,
    $headers = null) {

    $success = false;
    if (!is_null($to) && !is_null($subject) && !is_null($message)) {
      $success = mail($to, $subject, $message, $headers);
      return $success;
    } else {
      $headers = array();
      if (!empty($this->fromAddress)) {
        $headers[] = 'From: ' . $this->fromAddress;
      }

      if (!empty($this->CCAddress)) {
        $headers[] = 'CC: ' . $this->CCAddress;
      }

      if (!empty($this->BCCAddress)) {
        $headers[] = 'BCC: ' . $this->BCCAddress;
      }

      if ($this->sendText && !$this->sendHTML) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/plain; charset="windows-1250"';
        $headers[] = 'Content-Transfer-Encoding: 7bit';
        $message = $this->textBody;
      } elseif (!$this->sendText && $this->sendHTML) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset="windows-1250"';
        $headers[] = 'Content-Transfer-Encoding: 7bit';
        $message = $this->HTMLBody;
      } elseif ($this->sendText && $this->sendHTML) {
        $boundary = '==MP_Bound_xyccr948x==';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: multipart/alternative; boundary="' .
        $boundary . '"';

        $message = 'To je vícedílná zpráva ve formátu MIME.' . "\n";
        $message .= '--' . $boundary . "\n";
        $message .= 'Content-type: text/plain; charset="windows-1250"' .
                    "\n";
        $message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
        $message .= $this->textBody  . "\n";
        $message .= '--' . $boundary . "\n";

        $message .= 'Content-type: text/html; charset="windows-1250"' . "\n";
        $message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
        $message .= $this->HTMLBody  . "\n";
        $message .= '--' . $boundary . '--';
      }

      $success = mail($this->toAddress, $this->subject, $message,
        join("\r\n", $headers));
      return $success;
    }
  }
}
?>