ProjectCommon.Message=new Object();
//methods
//TODO перенести константы в свойства объекта
ProjectCommon.Message.show=function(message, isHtml)
{
    var MessageContainer=document.getElementById('project_message');
    if (!MessageContainer)
    {
        var ElementDOM=document.createElement('div');
        ElementDOM.id="project_message_container";
        ElementDOM.className="project-message"; //className???
        ElementDOM.style.display="none";
        //
        ElementDOM.innerHTML=
            "<img src='" + ProjectCommon.imagePrefix + "/close-button.png' class='close-button' onclick='ProjectCommon.Message.close()' >" +
            "<div id='project_message_text'></div>";
        //
        document.body.appendChild(ElementDOM);
        MessageContainer=ElementDOM;
    }
    var MessageText=document.getElementById('project_message_text');
    if (isHtml) MessageText.innerHTML=message;
    else        MessageText.textContent=message;
    MessageContainer.style.display='block';
};
ProjectCommon.Message.close=function()
{
    var MessageDOM=document.getElementById('project_message_container');
    if (MessageDOM) MessageDOM.style.display="none";
};