Admin=new Object();
//TODO разбить файл по принципу MVC
//TODO вынести файлы со ИД и CSS HTML элементов в отдельный файл
//TODO свойства должны задываться на сервере
//свойства
/**
 * Текущий вид данных о пользователях
 *
 * @type {null|string}
 */
Admin.dataViewId=null;
Admin.dataTypeChangeUrl=null;
Admin.userTableId='users_table_admin';
Admin.userTableRowCls='users-table_admin__row';
Admin.userTableRowSelectCls='users-table_admin__row_selected';
Admin.userTableCellSurnameCls='users-table_admin__cell_surname';
Admin.userTableCellFirstNameCls='users-table_admin__cell_first_name';
Admin.userTableCellPatronymicCls='users-table_admin__cell_patronymic';
Admin.userTableCellLoginCls='users-table_admin__cell_login';
Admin.userCreateWindow=new Object();
Admin.userCreateWindow.id='admin_user_create_window';
Admin.userEditWindow=new Object();
Admin.userEditWindow.id='admin_user_edit_window';
Admin.userEditWindow.surnameFieldId='admin_user_edit_window_surname_field';
Admin.userEditWindow.firstnameFieldId='admin_user_edit_window_firstname_field';
Admin.userEditWindow.patronymicFieldId='admin_user_edit_window_patronymic_field';
Admin.userEditWindow.loginFieldId='admin_user_edit_window_login_field';
Admin.userEditWindow.inputId='admin-user-edit-window__input_id';
Admin.userEditWindow.containerForId='admin_user_edit_window_head_id_container';
//методы
/**
 * Меняет вид данных о пользователях на следующий по порядку
 */
Admin.dataViewNext= function ()
{
    window.location.assign( Admin.dataTypeChangeUrl + '?dataViewId=' + encodeURIComponent(Admin.dataViewId) );
};
Admin.userCreateWindow.close=function()
{
  document.getElementById(Admin.userCreateWindow.id).style.display='none';
};
Admin.userCreateWindow.show=function()
{
  document.getElementById(Admin.userCreateWindow.id).style.display='block';
};
Admin.userEditWindow.show=function()
{
    var rowSelected=document.getElementById(Admin.userTableId).getElementsByClassName(Admin.userTableRowSelectCls);
    if ( 0 == rowSelected.length ) return;
    rowSelected=rowSelected[0];
    var EditWindow=document.getElementById(Admin.userEditWindow.id);
    var userId=rowSelected.attributes['data-user_id'].value;
    document.getElementById(Admin.userEditWindow.containerForId).textContent=userId;
    if ('self'==Admin.dataViewId)
    {
        document.getElementById(Admin.userEditWindow.inputId).value=userId;
        document.getElementById(Admin.userEditWindow.surnameFieldId).value=rowSelected.getElementsByClassName(Admin.userTableCellSurnameCls)[0].textContent;
        document.getElementById(Admin.userEditWindow.firstnameFieldId).value=rowSelected.getElementsByClassName(Admin.userTableCellFirstNameCls)[0].textContent;
        document.getElementById(Admin.userEditWindow.patronymicFieldId).value=rowSelected.getElementsByClassName(Admin.userTableCellPatronymicCls)[0].textContent;
        document.getElementById(Admin.userEditWindow.loginFieldId).value=rowSelected.getElementsByClassName(Admin.userTableCellLoginCls)[0].textContent;
        EditWindow.style.display='block';
    }
    else if ('yii2'==Admin.dataViewId)
    {
        //TODO Добавить редактирование пользователя через объекты Yii2 фреймворка
        alert('В разработке');
    }
    //EditWindow.style.display='block';
};
Admin.userEditWindow.close=function()
{
    document.getElementById(Admin.userEditWindow.id).style.display='none';
};
Admin.userDelete=function()
{
    var rowSelected=document.getElementById(Admin.userTableId).getElementsByClassName(Admin.userTableRowSelectCls);
    if ( 0 == rowSelected.length ) return;
    rowSelected=rowSelected[0];
    if ('self'==Admin.dataViewId)
    {
        window.location.assign('/admin/users/users-tools/user-delete/?id=' + encodeURIComponent(rowSelected.attributes['data-user_id'].value));
    }
    else if ('yii2'==Admin.dataViewId)
    {
        //TODO Добавить удаление пользователя через объекты Yii2 фреймворка
        alert('В разработке');
    }
};
Admin.userTableTrSelect=function(row)
{
    var Reg=new RegExp('\\s*\\b' + Admin.userTableRowSelectCls +'\\b\\s*');
    var rowSelectOn=true;
    //если строка уже выделена, то отмечаем, что выделение надо снять
    if ( row.className.match(Reg) ) rowSelectOn=false;
    //
    var rowMas=document.getElementById(Admin.userTableId).getElementsByClassName(Admin.userTableRowCls);
    for(var n=0; n<rowMas.length;n++)
    {
        rowMas[n].className=rowMas[n].className.replace(Reg,'');
    }
    //если строка не была выделена, то выделяем её
    if (rowSelectOn) row.className+=' ' +Admin.userTableRowSelectCls;
};
