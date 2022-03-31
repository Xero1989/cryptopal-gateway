<!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button> -->

<div class="modal fade" id="modal_cryptopal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:6rem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Potvrda kupovine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <input type="hidden" id="product_id" value=""> 

                <div class="container text-center">
                    <h3 class="mb-4" id="modalTitle">Sportska jakna ActiveLook</h3>
                    <!-- <img id="modalImg" src="" alt=""> -->
                    <div class="mb-4" id="modalPrice"></div>
                    <div class="mb-4">
                        <label for="modalAmount" class="form-label">Količina</label>
                        <input min="1" max="100" step="1" type="number" value="1" class="form-control text-center" id="amount">
                    </div>
                    <div class="mb-4">
                        <div class="form-check disabled">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                            <label class="form-check-label" for="exampleRadios3">
                                Plaćanje karticom
                            </label>
                        </div>
                        <div class="form-check disabled">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                            <label class="form-check-label" for="exampleRadios3">
                                Plaćanje pouzećem
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Kripto plaćanje
                            </label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-primary" id="bt_cryptopal" onclick="javascript:get_app_url_from_cryptopal()">Nastavi kupovinu</button>
                    </div>
                </div>

            </div>

            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div> -->

        </div>
    </div>
</div>