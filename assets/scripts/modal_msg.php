<?php

if(!empty($_POST)){

  $result = '';
  $subject = $_POST['subject'];


  $result .= '<div class="modal-body" id="modal-msg">';
      $result .= '<div class="form-part">';

        $result .= '<div class="contact-form">';

        $result .= '<h4>Envoyez moi un message</h4>';

        $result .= '<form action="" id="contact-form-modal">';
        $result .= '<div class="row">';

        $result .= '<div class="col-md-12">
                      <div class="form-group">
                        <input type="text" 
                                name="name" 
                                id="name" 
                                placeholder="Votre nom" 
                                class="form-control">
                      </div>
                    </div>';

        $result .= '<div class="col-md-12">
                      <div class="form-group">
                        <input type="email" 
                                name="email" 
                                id="email" 
                                placeholder="Votre email" 
                                class="form-control">
                      </div>
                    </div>';

        $result .= '<div class="col-12">
                      <div class="form-group">
                        <input type="text" 
                          name="subject" 
                          id="subject" 
                          placeholder="Indiquer le sujet" 
                          class="form-control"
                          value="'.$subject.'">
                      </div>
                    </div>';

        $result .= '<div class="col-md-12">
                      <div class="form-group">
                        <textarea 
                            type="text" 
                            name="message" 
                            id="message" 
                            rows="5" 
                            placeholder="Votre message" 
                            class="form-control"></textarea>
                      </div>
                    </div>';

        $result .= '<div class="valideCheck-container">
                      <label class="checkbox">
                        <input class="checkbox_input" type="checkbox" name="valideCheck" id="valideCheck">
                          <svg class="checkbox_check" width="25" height="25">
                            <polyline points="20 6 9 17 4 12"></polyline>
                          </svg>
                      <span>Je donne mon autorisation pour etre recontacté</span></label>
                    </div>';

        $result .= '<div class="col-md-12">
                      <div class="send">
                        <input type="submit" 
                        name="sendMsg" 
                        id="sendMsg" 
                        class="btn sendMsg"  
                        value="Envoyer">
                      </div>
                    </div>';


        $result .= '</div>';
        $result .= ' </form>';

        $result .= '</div>';
      $result .= '</div>';
    $result .= '</div>';


  echo $result;
} 

?>