UsersGii={};
UsersGii.Controller={};
UsersGii.Controller.dataTypeChangeUrl=null;
UsersGii.Controller.dataTypeChange=function () {
    window.location.assign( UsersGii.Controller.dataTypeChangeUrl + '?dataViewId=' + encodeURIComponent(UsersGii.Model.dataViewId) );
};