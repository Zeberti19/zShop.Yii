if (!window.UserCreateWindows)
{
    UserCreateWindows=[];
    //========================
    UserCreateWindow={};
    UserCreateWindow.id=null;
    UserCreateWindow.idHtml=null;

    UserCreateWindow.close=function()
    {
        document.getElementById(this.idHtml).style.display='none';
    };
    UserCreateWindow.show=function()
    {
        document.getElementById(this.idHtml).style.display='block';
    };
    //==========================
}
