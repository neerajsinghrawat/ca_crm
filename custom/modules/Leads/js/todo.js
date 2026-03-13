$(document).ready(function(){

    window.currentTodoParent = $("input[name=record]").val();

    var refreshTimer=null;

    // popup elements
    var todooverlay = $("#todoPopupOverlay");
    var todopopup   = $("#todoPopupBox");
    var openTodoBtn = $("#openTodoBtnNew");
    var todosendBtn = $("#todoSendBtn");
    var todocancelBtn = $("#todoCancelBtn");
    var todostatusDiv = $("#todoStatus");
    var todohistoryDiv = $("#todoHistory");
    var textareaTodo = $("#chatMessageToDO");

    // ===== OPEN TODO POPUP =====
    $(document).on("click","#openTodoBtnNew",function(){

        todooverlay.show();
        todopopup.show();
        todostatusDiv.html('');
        textareaTodo.val('');

        fetchHistoryTodo();
        textareaTodo.focus();

        refreshTimer=setInterval(fetchHistoryTodo,3000);
    });
    $(document).on("click",".todoSubpanelBtn",function(){

        var recordId = $(this).data("id");

        console.log("Todo open for subpanel record:",recordId);

        window.currentTodoParent = recordId;

        todooverlay.show();
        todopopup.show();
        todostatusDiv.html('');
        textareaTodo.val('');

        fetchHistoryTodo();
        textareaTodo.focus();

        refreshTimer=setInterval(fetchHistoryTodo,3000);
    });

    // ===== OPEN FROM SUBPANEL =====
    /*$(document).on("click",".todoSubpanelBtn",function(){

        let rec=$(this).data("id");

        window.currentTodoParent = rec;

        $("#openTodoBtnNew").trigger("click");
    });*/

    // ===== CLOSE =====
    $(document).on("click","#todoCancelBtn,#todoPopupOverlay",function(){
        todooverlay.hide();
        todopopup.hide();
        clearInterval(refreshTimer);
        refreshTimer=null;
    });

    // ===== FETCH HISTORY =====
    function fetchHistoryTodo(){

        if(todohistoryDiv.html().trim()===''){
            todohistoryDiv.html('<div style="color:#666;">Loading To-Do history…</div>');
        }

        $.ajax({
            url:"index.php?entryPoint=chat_fetch",
            type:"GET",
            data:{
                lead_id:window.currentTodoParent,
                todo:1
            },
            success:function(res){

                let resp = res;

                if(resp.success){
                    renderTodo(resp.items);
                }else{
                    todohistoryDiv.html('<div style="color:red;">Error loading</div>');
                }
            }
        });
    }

    // ===== RENDER =====
    function renderTodo(items){

        todohistoryDiv.html('');

        if(!items || items.length===0){
            todohistoryDiv.html('<div style="color:#666;">No To-Do</div>');
            return;
        }

        items.forEach(function(it){

            var html=`
            <div class="chat-row">
                <div class="todo-bubble todo-me">
                    ${it.body}
                    <div class="todo-meta">${it.date}</div>
                </div>
            </div>`;

            todohistoryDiv.append(html);
        });

        todohistoryDiv.scrollTop(todohistoryDiv[0].scrollHeight);
    }

    // ===== SAVE TODO =====
    $(document).on("click","#todoSendBtn",function(){

        var msg=textareaTodo.val().trim();

        if(msg == ''){
            //todostatusDiv.css("color","red").html("Type todo");
            return;
        }

        todosendBtn.prop("disabled",true).html("Adding...");

        var formData=new FormData();
        formData.append("lead_id",window.currentTodoParent);
        formData.append("message",msg);
        formData.append("todo","1");

        $.ajax({
            url:"index.php?entryPoint=chat_save",
            type:"POST",
            data:formData,
            processData:false,
            contentType:false,
            success:function(res){

                todosendBtn.prop("disabled",false).html("ADD TO-DO");

                
                let resp = res;
                console.log('resp');
                console.log(resp);
                if(resp.success){
                    todostatusDiv.css("color","green").html("Added");
                    textareaTodo.val('');
                    fetchHistoryTodo();
                }else{
                    todostatusDiv.css("color","red").html("Error");
                }
            }
        });

    });

});
