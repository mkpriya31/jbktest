<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

 <div style="height:40px;"></div>
    <div class="assessment-container container">
        <div class="row">
            <div class="col-md-6 form-box">
                <form role="form" class="registration-form" action="javascript:void(0);">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>Lorem ipsum dolor sit amet</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit
                                </p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Firstname" id="fname">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Lastname" id="lname">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:3px;">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-3">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9 col-sm-9">
                                        <input type="text" class="form-control" placeholder="Contact Number" id="contact_number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email" class="form-email form-control" id="email" required>
                            </div>

                            <div class="form-group">
                                <select class="form-control">
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span> Lorem ipsum dolor sit amet</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit
                                </p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group">
                                <select class="form-control">
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Locationa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="pref_date">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option>Preffered Time</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Locationa</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function () {
        $(this).removeClass('input-error');
    });

    // next step
    $('.registration-form .btn-next').on('click', function () {
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;

        parent_fieldset.find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                next_step = false;
            } else {
                $(this).removeClass('input-error');
            }
        });

        if (next_step) {
            parent_fieldset.fadeOut(400, function () {
                $(this).next().fadeIn();
            });
        }

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
        $(this).parents('fieldset').fadeOut(400, function () {
            $(this).prev().fadeIn();
        });
    });

    // submit
    $('.registration-form').on('submit', function (e) {

        $(this).find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });

   
});
</script>
<style>
input[type="text"],
input[type="email"],
input[type="date"],
select.form-control {
    height: 50px;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    background: #f8f8f8;
    border: 3px solid #ddd;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 50px;
    color: #888;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

input[type="file"] {
    height: 35px;
    margin: 0;
    padding: 0 20px;
    vertical-align: bottom;
    background: #f8f8f8;
    border: 3px solid #ddd;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 30px;
    color: #888;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

input[type=radio] {
    margin-top: 8px !important;
}

textarea,
textarea.form-control {
    padding-top: 10px;
    padding-bottom: 10px;
    line-height: 30px;
}

input[type="text"]:focus,
input[type="password"]:focus,
textarea:focus,
textarea.form-control:focus {
    outline: 0;
    background: #fff;
    border: 3px solid #ccc;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
}

input[type="text"]:-moz-placeholder,
input[type="password"]:-moz-placeholder,
textarea:-moz-placeholder,
textarea.form-control:-moz-placeholder {
    color: #888;
}

input[type="text"]:-ms-input-placeholder,
input[type="password"]:-ms-input-placeholder,
textarea:-ms-input-placeholder,
textarea.form-control:-ms-input-placeholder {
    color: #888;
}

input[type="text"]::-webkit-input-placeholder,
input[type="password"]::-webkit-input-placeholder,
textarea::-webkit-input-placeholder,
textarea.form-control::-webkit-input-placeholder {
    color: #888;
}

button.btn {
    height: 50px;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    background: #26A69A;
    ;
    border: 0;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 50px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    text-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

button.btn:hover {
    opacity: 0.6;
    color: #fff;
}

button.btn:active {
    outline: 0;
    opacity: 0.6;
    color: #fff;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
}

button.btn:focus {
    outline: 0;
    opacity: 0.6;
    background: #26A69A;
    ;
    color: #fff;
}

button.btn:active:focus,
button.btn.active:focus {
    outline: 0;
    opacity: 0.6;
    background: #26A69A;
    ;
    color: #fff;
}


/*style.css**/

body {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    color: #888;
    line-height: 30px;
    text-align: center;
}

strong {
    font-weight: 500;
}

a,
a:hover,
a:focus {
    color: #26A69A;
    ;
    text-decoration: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

h1,
h2 {
    margin-top: 10px;
    font-size: 38px;
    font-weight: 100;
    color: #555;
    line-height: 50px;
}

h3 {
    font-size: 22px;
    font-weight: 300;
    color: #555;
    line-height: 30px;
}

::-moz-selection {
    background: #26A69A;
    ;
    color: #fff;
    text-shadow: none;
}

::selection {
    background: #26A69A;
    ;
    color: #fff;
    text-shadow: none;
}

.btn-link-1 {
    display: inline-block;
    height: 50px;
    margin: 0 5px;
    padding: 16px 20px 0 20px;
    background: #26A69A;
    font-size: 16px;
    font-weight: 300;
    line-height: 16px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}

.btn-link-1:hover,
.btn-link-1:focus,
.btn-link-1:active {
    outline: 0;
    opacity: 0.6;
    color: #fff;
}

.btn-link-2 {
    display: inline-block;
    height: 50px;
    margin: 0 5px;
    padding: 15px 20px 0 20px;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #fff;
    font-size: 16px;
    font-weight: 300;
    line-height: 16px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}

.btn-link-2:hover,
.btn-link-2:focus,
.btn-link-2:active,
.btn-link-2:active:focus {
    outline: 0;
    opacity: 0.6;
    background: rgba(0, 0, 0, 0.3);
    color: #fff;
}


/***** Top content *****/

.form-box {
    padding-top: 40px;
    font-family: 'Roboto', sans-serif !important;
}

.form-top {
    overflow: hidden;
    padding: 0 25px 15px 25px;
    background: #26A69A;
    -moz-border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0;
    text-align: left;
    color: #fff;
    transition: opacity .3s ease-in-out;
}

.form-top h3 {
    color: #fff;
}

.form-bottom {
    padding: 25px 25px 30px 25px;
    background: #eee;
    -moz-border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
    border-radius: 0 0 4px 4px;
    text-align: left;
    transition: all .4s ease-in-out;
}

.form-bottom:hover {
    -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}

form .form-bottom button.btn {
    min-width: 105px;
}

form .form-bottom .input-error {
    border-color: #d03e3e;
    color: #d03e3e;
}

form.registration-form fieldset {
    display: none;
}
</style>