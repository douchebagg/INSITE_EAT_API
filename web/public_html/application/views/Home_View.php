<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html ng-app="myapp">
<head>
    <title>Home</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" type="text/css" href="<?= base_url('js/home.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#top', () => {
            $('html, body').animate({scrollTop:0}, 250);
            return false;
        });
        let app = angular.module('myapp', []);
        app.controller('myctrl', ($scope, $http) => {
            $scope.refresh = () => {
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                    });
            }
            $scope.refresh();
        });
    </script>
</head>
<body ng-controller="myctrl">
    <div class="container" style="padding-bottom: 100px;">
        <div class="row" style="padding-bottom: 25px;">
            <div class="col-md-12">
                <div class="row" style="background: #fafafa; border-radius: 3px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
                    <div class="col-md-4 title-card">
                        <?= $session['name'] ?>
                    </div>
                    <div class="col-md-8 text-right button-container">
                        <input type="text" name="search" ng-model="search" ng-blur="search = ''">
                        <a href="<?= base_url('review') ?>" style="margin-top: 10px">
                            My Review
                        </a>
                        <?php if(!$session['other']) { ?>
                        <a href="<?= base_url('profile') ?>">
                            Profile
                        </a>
                        <?php } ?>
                        <a href="<?= base_url('logout') ?>">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" ng-if="restaurant !== 'No data in Restaurant api.'">
            <div class="col-md-3" ng-repeat="x in restaurant | filter: search">
                <div class="polaroid">
                    <a href="<?= base_url('restaurant') ?>?id={{x.RES_ID}}" style="text-decoration: none">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.RES_IMAGE}}" style="width:100%" ng-hide="x.RES_IMAGES === NULL">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:100%" ng-hide="x.RES_IMAGES !== NULL">
                        <div class="content">
                            <div>{{x.RES_NAME}}</div>
                            <hr>
                            <div>
                                <span>{{x.RES_SCORE}}</span>
                                <span class="fa fa-star" style="color: #ec2652;"></span>
                            </div>
                            <div>post by: {{x.POST_BY}}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" ng-if="restaurant === 'No data in Restaurant api.'">
            <div class="col-md-12">
                <div class="polaroid">
                    <div class="content">
                        <div class="title">No information in database.</div>
                    </div>
                </div>
            </div>
        </div>
        <a id="top" class="footer" href="">
            <i class="fa fa-level-up"></i>
        </a>
    </div>
</body>
</html>