<style>
    .loginMargins {
        max-width: 800px;
        margin: 0 auto;
        padding: 100px 20px 20px 20px;
    }
    .loginMarginsWizard {
        max-width: 800px;
        margin: 0 auto;
        padding: 0px 20px 20px 20px;
    }

    .login-logo {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
    }
</style>
<div  class="ibox-content"  ng-controller="signupCtrl as signup">
    <div class="" ng-hide='main.signupWizard'>
        <div class="text-center" >
            <img height="100" width="300" src="../img/LogoFiles/justopex_logo_hires_transparent.png" alt=""/>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <form role="form" name="signupForm" class="form-horizontal ">
                    <div class="col-md-offset-2">
                        <h3 style="margin-bottom:40px;">Welcome to JustOpex. Please fill in the details below to create your account on Navigate.</h3>
                        <div class="form-group" ng-class="{'has-success':signupForm.reqNewUserEmail.$valid, 'has-error':signupForm.reqNewUserEmail.$touched && signupForm.reqNewUserEmail.$invalid}">
                            <label class="col-sm-10" for="reqNewUserEmail">Email</label>
                            <div class="col-sm-6">
                                <input type="email" ng-pattern="emailFormat" name="reqNewUserEmail" class="form-control" check-for-unique check-for-unique-task="validate new user email"  ng-model="signup.add.reqNewUserEmail" placeholder="Please enter email address" required ng-model-options="{ debounce: 1000 }">
                                <span class="text-info" ng-show="signupForm.reqNewUserEmail.$pending.checkForUnique">Checking if this name is available...</span>
                                <span class="text-danger" ng-show="signupForm.reqNewUserEmail.$error.checkForUnique">This Email is already taken!</span>
                                <span class="text-success" ng-show="checkForUniqueValid && signup.add.reqNewUserEmail">Available</span>
                                <span class="text-danger" ng-show="signupForm.reqNewUserEmail.$touched && signupForm.reqNewUserEmail.$invalid">Please enter a valid email id</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Person Name</label>
                            <div class="col-sm-2" ng-class="{'has-success':signupForm.reqTitle.$valid, 'has-error':signupForm.reqTitle.$touched && signupForm.reqTitle.$invalid}">
                                <select class="form-control" name="reqTitle" ng-model="signup.add.reqTitle" required>
                                    <option value="">Title</option><option value="mr">Mr.</option><option value="mrs">Mrs.</option><option value="ms">Ms.</option><option value="dr">Dr.</option><option value="drs">Drs.</option>
                                </select>
                                <!--                            <span class="text-danger" ng-show="signupForm.reqTitle.$touched && signupForm.reqTitle.$invalid">Please select title</span>   -->
                            </div>
                            <div class="col-sm-4"  ng-class="{'has-success':signupForm.reqFirstName.$valid, 'has-error':signupForm.reqFirstName.$touched && signupForm.reqFirstName.$invalid}">
                                <input type="text" class="form-control" name="reqFirstName" ng-model="signup.add.reqFirstName" placeholder="First name" required>
                                <!--                            <span class="text-danger" ng-show="signupForm.reqFirstName.$touched && signupForm.reqFirstName.$invalid">Please enter First Name</span>  -->
                            </div>
                            <div class="col-sm-4"  ng-class="{'has-success':signupForm.reqLastName.$valid, 'has-error':signupForm.reqLastName.$touched && signupForm.reqLastName.$invalid}">
                                <input type="text" class="form-control" name="reqLastName" ng-model="signup.add.reqLastName" placeholder="Last name" required>
                                <!--                            <span class="text-danger" ng-show="signupForm.reqLastName.$touched && signupForm.reqLastName.$invalid">Please enter last Name</span>   -->
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6" ng-class="{'has-success':signupForm.reqCompany.$valid, 'has-error':signupForm.reqCompany.$touched && signupForm.reqCompany.$invalid}">
                                <label class="" for="reqCompany">Company Name</label>
                                <input type="text" name="reqCompany" class="form-control" ng-model="signup.add.reqCompany" placeholder="Please enter company name" required>
                            </div>

                            <div class="col-lg-4" ng-class="{
                                        'has-success':signupForm.reqDesignation.$valid,
                                                'has-error'
                                                :signupForm.reqDesignation.$touched && signupForm.reqDesignation.$invalid}
                                 ">
                                <label class="" for="reqDesignation">Designation</label>
                                <input type="text" name="reqDesignation" class="form-control" ng-model="signup.add.reqDesignation" placeholder="Please enter your designation at this company" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-4" ng-class="{
                                        'has-success':signupForm.reqCountry.$valid,
                                                'has-error'
                                                :signupForm.reqCountry.$touched && signupForm.reqCountry.$invalid}
                                 ">
                                <label class="" for="reqCountry">Country</label>
                                <select class="form-control" ng-options="o as o for o in main.countryList" ng-model="signup.add.reqCountry" name="reqCountry" required>
                                    <option value="">Select country</option>
                                </select>
                            </div>

                            <div class="col-lg-8">
                                <label class="col-lg-12" for="reqTelephoneCC">Telephone</label>
                                <div class="col-lg-2" ng-class="{'has-success':signupForm.reqTelephoneCC.$valid, 'has-error':signupForm.reqTelephoneCC.$touched && signupForm.reqTelephoneCC.$invalid}">
                                    <input type="number" name="reqTelephoneCC" class="form-control" ng-model="signup.add.reqTelephoneCC" placeholder="Code" required>
                                    <!--                            <span class="text-danger" ng-show="signupForm.reqTelephoneCC.$touched && signupForm.reqTelephoneCC.$invalid">Please enter Country Code</span>   -->
                                </div>
                                <div class="col-lg-4" ng-class="{'has-success':signupForm.reqTelephoneNum.$valid, 'has-error':signupForm.reqTelephoneNum.$touched && signupForm.reqTelephoneNum.$invalid}">
                                    <input type="number" name="reqTelephoneNum" class="form-control" ng-model="signup.add.reqTelephoneNum" placeholder="Preferred phone number" required>
                                    <!--                            <span class="text-danger" ng-show="signupForm.reqTelephoneNum.$touched && signupForm.reqTelephoneNum.$invalid">Please your Preferred Phone number</span>  -->
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6" ng-class="{'has-success':signupForm.reqCompany.$valid, 'has-error':signupForm.reqCompany.$touched && signupForm.reqCompany.$invalid}">
                                <label class="" for="reqReferredBy">Referred by</label>
                                <input type="text" name="reqReferredBy" class="form-control" ng-model="signup.add.reqReferredBy" placeholder="Please enter referrer name">
                            </div>
                        </div>

                        <label ng-hide="2">{{signup.add.task = "signup"}}</label>
                        <div class="form-group" ng-controller="reCaptchaCtrl">
                            <div class="col-sm-offset-0 col-sm-12" vc-recaptcha ng-model="signup.add.recaptcha" key="main.reCaptchaKey" theme="'light'" on-create="setWidgetId(widgetId)" on-success="setResponse(response)" on-expire="cbExpiration()"  style="margin-top: 20px;"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"  style="margin-top: 20px;">
                                <button type="button" ng-click="signup.update(signup.add);" class="btn btn-primary full-width" ng-disabled="signupForm.$invalid">Sign-up</button>
                            </div>
                            <div class="col-sm-2"  style="margin-top: 20px;">
                                <button type="button" ng-click="signup.openHelpPage();" class="btn btn-info full-width">Help</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>