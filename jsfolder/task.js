//default print all the task in front and task section, image
$(document).ready(function () {
    tasks();
    all_task();
    image();
});


// in home it show all the todays task
function tasks() {
    console.log("tamil");

    $.ajax({
        type: 'GET',
        url: '../phpfolder/retrieve.php',
        data: {
            task: true,
        },
        dataType: 'json',
        success: function (response) {
            try {
                if (response.status === 200) {
                    displayTasks(response.answer);
                } else {
                    console.error('Unexpected response:', response);
                }
            } catch (error) {
                console.log("Error parsing JSON response:", error);
            }
        },
        error: function (error) {
            console.log("Request failed:", error);
        }
    });
}
// the above function get all the task in an array this function print all the tasks
function displayTasks(tasks) {
    var container = $('.task-container');
    container.empty();
    if (!tasks || tasks === 'no data') {
    console.log('No tasks found');
    return;
}

// Get the tasks container element
var container = $('.task-container');


container.append('<div class="row w-25 task-container px-3 rounded-4 shadow" style="background-color: #113A5D; color: whitesmoke;">');
container.append('<h2 class="mt-3" style="font-weight:700" >TODAYS REMINDER</h2>');
// container.append('<hr style="border-top: 5px solid #fcfcfc; width: 100%;">');

for (var i = 0; i < tasks.length; i++) {
    var task = tasks[i];

    var taskDiv = $('<div class="row px-3 rounded-4 shadow" style="background-color: #113A5D; color: whitesmoke; overflow-x: hidden;">');
    taskDiv.append('<hr style="border-top: 5px solid #fcfcfc; width: 100%;">');
    taskDiv.append('<h4 style="font-weight: 800;">TASK CATEGORY :</h4>');
    taskDiv.append('<h4 class="mb-2">' + task.category + '</h4>');
    taskDiv.append('<h4 style="font-weight: 800;">ABOUT TASK :</h4>');
    var aboutTaskDiv = $('<h4 class="mb-3" style="max-height: 100px; overflow-y: auto;"></h4>');
    aboutTaskDiv.text(task.abouttask);
    taskDiv.append(aboutTaskDiv);
    // Append the taskDiv to the tasks container
    container.append(taskDiv);
    }
}




//this function in the task section shows all the tasks
function all_task() {
    console.log("tamil working");
    $.ajax({
        type: 'GET',
        url: '../phpfolder/retrieve.php',
        data: {
            all_task: true,
        },
        dataType: 'json',
        success: function (response) {
            try {
                if (response.status === 200) {
                    console.log(response);
                    print_data(response.answer);
                } else {
                    console.error('Unexpected response:', response);
                }
            } catch (error) {
                console.log("Error parsing JSON response:", error);
            }
        },
        error: function (error) {
            console.log("Request failed:", error);
        }
    });
}

// the above function retrieve the tasks it shows all the tasks
function print_data(tasks1) {
    var container = $('.alltaskcontainer'); 
    container.empty();

    if (!tasks1 || tasks1 === 'no data') {
        console.log('No tasks found');
        return;
    }
    for (var i = 0; i < tasks1.length; i++) {
        var task = tasks1[i];

        var taskHtml = '<div class="col-12 col-md-6">';
taskHtml += '<div class="card m-3" style="background-color: #113A5D; color: white;">';
taskHtml += '<div class="datas px-3 py-3">';
taskHtml += '<h3 style="font-weight: 800;"class="py-1">DATE</h3>';
taskHtml += '<h4 class="bg-body-secondary p-2 rounded-3" style="color: black;">' + task.date + '</h4>';
taskHtml += '<h3 style="font-weight: 800;" class="my-3">CATEGORY</h3>';
taskHtml += '<h4 class="bg-body-secondary p-2 rounded-3" style="color: black;">' + task.category + '</h4>';
taskHtml += '<h3 style="font-weight: 800;" class="my-2">ABOUT TASK</h3>';
taskHtml += '<h4 style="text-align: justify; color: black;" class="bg-body-secondary p-2 rounded-3  ">' + task.abouttask + '</h4>';
taskHtml += '<div class="col d-flex justify-content-end">';
taskHtml += `<button class="btn btn-primary my-3 mx-2" style="width: 50%;" data-bs-toggle="modal" data-bs-target="#target1" onclick="edit_data(${task.id})">EDIT</button>`;
taskHtml += `<button class="btn btn-danger my-3 mx-2" style="width: 50%;" onclick="delete_data(${task.id})">DELETE</button>`;
taskHtml += '</div>';
taskHtml += '</div>';
taskHtml += '</div>';
taskHtml += '</div>';
        // Append the HTML structure for each task to the container
        container.append(taskHtml);
    }
}

// this is when the delete button is click they pass the taskid and delete the task
function delete_data(taskid)
{
    
    $.ajax({
        type: 'POST',
        url: '../phpfolder/delete.php',
        data: {
            delete: true,
            id:taskid,
        },
        dataType: 'json',
        success: function (response) {
            try {
                if (response.status === 200) {
                    console.log(response);
                    $.notify(response.message, "success");
                    all_task();
                } else {
                    console.error('Unexpected response:', response);
                }
            } catch (error) {
                console.log("Error parsing JSON response:", error);
            }
        },
        error: function (error) {
            console.log("Request failed:", error);
        }
    });
}


//edit task they pass the task id then open the model to change the task
function edit_data(taskid) {
    console.log(taskid);
    $('#edittask_details').submit(function (event) {
        event.preventDefault();
        
        var task_date = $('#etdate').val();
        var task_category = $('#etcategory').val();
        var task_abouttask = $('#etabouttask').val();
        console.log(task_date);
        console.log(task_category);
        console.log(task_abouttask);
        $.ajax({
            type: 'POST',
            url: '../phpfolder/delete.php',
            data: {
                update: true,
                id: taskid,
                edit_taskdate: task_date,
                edit_taskcategory: task_category,
                edit_taskabouttask: task_abouttask,
            },
            dataType: 'json',
            success: function (response) {
                try {
                    $('#edittask_details')[0].reset();
                    all_task();
                    tasks();
                    close2();
                    console.log(response);
                    if (response.status == 200 || response.status == 220 || response.status == 240) {
                        console.log(response.message);
                        $.notify(response.message, "success");
                    } else if (response.status == 300) {
                        console.log(response.message);
                        $.notify(response.message, "success");
                        console.log("tamil");
                        window.location.href = 'home.html';
                    } else {
                        console.log(response.message);
                        $.notify(response.message, "success");
                    }
                } catch (error) {
                    console.log("Error parsing JSON response:", error);
                    // Handle the error or log it as needed
                }
            },
            error: function (error) {
                console.log("2");
                console.log(error);
            }
        });
    });
}
function closemodel() {
    document.getElementById('close-model').click();
  } 