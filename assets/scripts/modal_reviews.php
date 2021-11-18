<?php

$result = '';




$result .= '<div class="modal-body" id="modal-reviews">';
$result .= '<div class="form-part">';

$result .= '<div class="contact-form">';

$result .= '<h4>Laisser un Avis</h4>';

$result .= '<form action="" id="add-modal-reviews">';
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
                        <input type="text" 
                                name="company" 
                                id="company" 
                                placeholder="Votre entreprise" 
                                class="form-control">
                      </div>
                    </div>';

$result .= '<div class="col-md-12">
                      <div class="form-group">
                      <label for="add_logo" class="custom-upload">
                         <p>Ajouter votre logo</p>
                          <i class="fas fa-cloud-upload-alt"></i>
                      </label>
                        <input type="file" 
                                name="add_logo" 
                                id="add_logo" 
                                placeholder="Votre logo" 
                                class="form-control dnone">
                      </div>
                    </div>';

$result .= '<div class="col-md-12">
              <div class="notation_block">
                <p>Votre Note :</p>
                <div class="stars-wrapper">
                  <input type="checkbox" id="st1" name="st1" value="5" />
                  <label for="st1"><i class="fas fa-star"></i></label>
                  <input type="checkbox" id="st2" name="st2" value="4" />
                  <label for="st2"><i class="fas fa-star"></i></label>
                  <input type="checkbox" id="st3" name="st3" value="3" />
                  <label for="st3"><i class="fas fa-star"></i></label>
                  <input type="checkbox" id="st4" name="st4" value="2" />
                  <label for="st4"><i class="fas fa-star"></i></label>
                  <input type="checkbox" id="st5" name="st5" value="1" />
                  <label for="st5"><i class="fas fa-star"></i></label>
                </div>
            </div>
          </div>';

$result .= '<div class="col-md-12">
                      <div class="form-group">
                        <textarea  
                            name="contenu" 
                            id="contenu" 
                            rows="5" 
                            placeholder="Votre Avis" 
                            class="form-control"></textarea>
                      </div>
                    </div>';


$result .= '<div class="col-md-12">
                      <div class="send">
                        <input type="submit" 
                        name="sendReview" 
                        id="sendReview" 
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
