//*INIT*//
var app = angular.module("productApp", ['ngSanitize']);

app.factory('jQuery', function() {
    return $;
});








app.controller("customPropCtrl", function($scope, propService,jQuery) {
    $scope.props = [];
    $scope.productId = 57;
    $scope.customProperty = {};
    $scope.customPropertyType = 1;
    $scope.lang;

    setTimeout(function(){
        propService.getProps({product_id:$scope.productId,lang:$scope.lang},function(dataResponse) {
            $scope.props = dataResponse;
            setTimeout(function(){
                $.each(jQuery(".dropzone-ang"),function(index,element){
                    jQuery(element).dropzone({ url: Routing.generate('custom_add_photo')+'?id='+$scope.props[index].id });
                })
            },1000);
        });
    },100);


    $scope.addProp = function(){
        propService.addProp($scope.customProperty,function(dataResponse) {
            $scope.props = dataResponse;
            $scope.customProperty.name = "";
            $scope.customProperty.description = "";
        });
        return false;
    }

    $scope.updateProp = function(){

        propService.updateProp($scope.customProperty,function(dataResponse) {
            $scope.props = dataResponse;
            $scope.formEditProperty = false;
            $scope.customProperty.name = "";
            $scope.customProperty.description = "";
        });
        return false;
    }

    $scope.deleteCustomAsset = function(property,asset){

        propService.deleteCustomAsset(asset,function(dataResponse) {
            var index = property.assets.indexOf(asset);
            if (index > -1) {
                property.assets.splice(index, 1);
            }
        });
        return false;
    }

    $scope.processForm = function(){
        if($scope.customProperty.name!='' || $scope.customProperty.description!=''){
            $scope.customProperty.lang = $scope.lang;
            if($scope.formEditProperty){
                $scope.updateProp();
            }else{
                $scope.addProp();
            }
        }
        return false;
    }



    $scope.newProperty = function(){
        $scope.formEditProperty = false;
        $scope.formAddProperty = !$scope.formAddProperty;
        $scope.customProperty.name = "";
        $scope.customProperty.description = "";
    }
    $scope.editProp = function(property){
        $scope.customProperty = property;
        $scope.formAddProperty = true;
        $scope.formEditProperty = true;
    }

    $scope.deleteProp = function(property){

        if(!$scope.deletingProperty && confirm('Confirm !')){
            $scope.deletingProperty = true;
        }else{
            return;
        }

        propService.deleteProperty({id:property.id},function(data) {
            var index = $scope.props.indexOf(property);
            if (index > -1) {
                $scope.props.splice(index, 1);
                $scope.pagedItems = [$scope.claim];
                $scope.deletingProperty = false;
            }
        });
    }




});



app.service("propService", function($http) {

    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    this.postData = function (params,url,callbackFunc){
        $http.post(url,$.param(params)).success(function(data){
            callbackFunc(data);
        }).error(function(){
        });
    };

    this.addProp = function(property,callbackFunc) {
        this.postData(property,Routing.generate("product_add_custom_property"),callbackFunc);
    };
    this.deleteCustomAsset = function(asset,callbackFunc) {
        this.postData(asset,Routing.generate("product_delete_custom_property_asset"),callbackFunc);
    };
    this.updateProp = function(property,callbackFunc) {
        this.postData(property,Routing.generate("product_update_custom_property"),callbackFunc);
    };

    this.deleteProperty = function(params,callbackFunc) {
        this.postData(params,Routing.generate("product_delete_custom_property"),callbackFunc);
    };

    this.getProps = function(params,callbackFunc) {
        this.postData(params,Routing.generate("product_get_custom_properties"),callbackFunc);
    };


});