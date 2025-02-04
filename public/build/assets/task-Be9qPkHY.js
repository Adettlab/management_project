class c{constructor(){this.projects=[],this.isLoading=!0,this.loadingElement=document.getElementById("loading"),this.modalCreate=document.getElementById("modalCreate"),this.modalTransfer=document.getElementById("modalTransfer"),this.modalShowC=document.getElementById("modalShow"),this.modalEdit=document.getElementById("modalEdit"),this.openModalCreateBtn=document.getElementById("openModalCreateBtn"),this.closeModalCreateBtn=document.getElementById("closeModalCreateBtn"),this.openModalTransferBtn=document.getElementById("openModalTransferBtn"),this.closeModalTransferBtn=document.getElementById("closeModalTransferBtn"),this.statusMap={todo:1,in_progress:2,review:3,completed:4},this.initializeEventListeners()}toggleLoading(){this.isLoading?this.loadingElement.classList.remove("hidden"):this.loadingElement.classList.add("hidden")}initializeEventListeners(){var t,s,o,a;(t=this.openModalCreateBtn)==null||t.addEventListener("click",()=>this.openModal("create")),(s=this.closeModalCreateBtn)==null||s.addEventListener("click",()=>this.closeModal("create")),(o=this.openModalTransferBtn)==null||o.addEventListener("click",()=>this.openModal("transfer")),(a=this.closeModalTransferBtn)==null||a.addEventListener("click",()=>this.closeModal("transfer")),window.addEventListener("click",n=>{n.target===this.modalCreate&&this.closeModal("create"),n.target===this.modalTransfer&&this.closeModal("transfer"),n.target===this.modalShowC&&this.closeModal("modalShow"),n.target===this.modalEdit&&this.closeModalShow("modalEdit")});const e=document.getElementById("project_id");e&&e.addEventListener("change",()=>this.checkProjectId()),this.checkProjectId(),this.addDisabledButtonStyles(),this.fetchTasks()}openModal(e){const t=e==="create"?this.modalCreate:this.modalTransfer;t==null||t.classList.remove("hidden")}closeModal(e){const t=e==="create"?this.modalCreate:this.modalTransfer;t==null||t.classList.add("hidden"),document.querySelectorAll("ul").forEach(s=>s.classList.add("hidden"))}allowDrop(e){e.preventDefault()}drag(e){e.dataTransfer.setData("text",e.target.id)}drop(e){e.preventDefault();const t=e.currentTarget,s=e.dataTransfer.getData("text"),o=document.getElementById(s);t.appendChild(o);const a=this.statusMap[t.id];this.updateTaskStatus(o.getAttribute("data-project-id"),o.getAttribute("data-task-id"),a)}async updateTaskStatus(e,t,s){const o=document.querySelector('meta[name="csrf-token"]').content;try{const n=await(await fetch(`/tasks/${t}/update-status`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":o},body:JSON.stringify({task_status_id:s})})).json();n.success?(console.log(`Task ${t} status updated successfully.`),console.log(n),this.updateFrontendTask(e,n.task)):console.error("Failed to update task status")}catch(a){console.error("Error:",a)}}async updateFrontendTask(e,t){const s=await this.projects.find(a=>a.id==e);if(!s){console.error("Project not found");return}const o=await s.tasks.find(a=>a.id===t.id);if(!o){console.error("Task not found");return}o.task_status_id=t.task_status_id,o.task_status=t.task_status,o.time_log=t.time_log,console.log(this.projects)}toggleDropdown(e,t,s){s&&s.preventDefault();const o=document.getElementById(e),a=document.getElementById(t);o.classList.contains("hidden")?(o.classList.remove("hidden","opacity-0","scale-95","-translate-y-2"),a.style.transform="rotate(180deg)"):(o.classList.add("hidden","opacity-0","scale-95","-translate-y-2"),a.style.transform="rotate(0)")}async checkProjectId(){const e=document.getElementById("project_id_transfer"),t=document.getElementById("dropdown-transfer-employee");t&&(e!=null&&e.value?(this.setButtonState(t,!1),await this.populateEmployeeDropdown(e.value)):this.setButtonState(t,!0))}async fetchTasks(e=""){this.destroyElement(),this.isLoading=!0,this.toggleLoading,await fetch(`/tasks/get-tasks?date=${e}`).then(t=>t.json()).then(t=>{if(t.length===0){this.isLoading=!1,this.toggleLoading(),document.getElementById("no_tasks").classList.remove("hidden");return}this.projects=t,document.getElementById("no_tasks").classList.add("hidden"),this.renderTasks(),this.renderProjectsDropdown()}).catch(t=>console.error("Error fetching tasks:",t))}async populateEmployeeDropdown(e){try{const s=await(await fetch(`/tasks/${e}/employees?type=team`)).json(),o=document.getElementById("trasfer-employee-dropdown");o.innerHTML=s.map(a=>`
                <li class="block px-4 py-2 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md"
                    onclick="taskManager.listOnClick(event, 'trasfer-employee-value', 'trasfer-employee-dropdown', 'trasfer-employee-icon', 'assigned_project_employee_id', ${a.id})">
                    ${a.employee.user.name}
                </li>
            `).join("")}catch(t){console.error("Error populating employee dropdown:",t)}}setButtonState(e,t){e.disabled=t,t?e.classList.add("opacity-50","cursor-not-allowed"):e.classList.remove("opacity-50","cursor-not-allowed")}async listOnClick(e,t,s,o,a,n){if(e.target.tagName==="LI"){const d=e.target.textContent.trim();if(a){const i=document.getElementById(a);i&&(i.value=n)}const l=document.getElementById(t);if(l&&(l.textContent=d),this.toggleDropdown(s,o),document.getElementById("modalTransfer").contains(document.getElementById(a)))this.checkProjectId();else try{const r=await(await fetch(`/tasks/${n}/employees`)).json();document.getElementById("employee_create").value=r[0].id}catch(i){console.error("Error fetching employee data:",i)}}}addDisabledButtonStyles(){const e=document.createElement("style");e.textContent=`
            button[disabled] {
                opacity: 0.5;
                cursor: not-allowed;
            }
        `,document.head.appendChild(e)}filterProjects(e,t,s,o){if(e.target.tagName==="LI"){const a=e.target.textContent.trim(),n=e.target.dataset.projectValue,d=document.getElementById(t);d&&(d.textContent=a),this.renderTasks(o,n),this.toggleDropdown(s,"projects-icon")}}renderTasks(e="0"){this.destroyElement(),(e=="0"?this.projects:this.projects.filter(s=>s.id==e)).forEach(s=>{s.tasks.forEach(o=>{const a=s.employees.find(l=>l.id==o.assigned_project_employee.employee_id),d={"To-do":"todo","In Progress":"in_progress",Review:"review",Completed:"completed"}[o.task_status.name];if(d){const l=document.getElementById(d);l&&(this.isLoading=!1,this.toggleLoading(),l.innerHTML+=this.templateTasks(o,s,a))}})})}renderProjectsDropdown(){const e=document.getElementById("projects-dropdown"),s=[{id:0,name:"Projects"},...this.projects].map(o=>`
            <li
                class="block px-4 py-2 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md w-full"
                data-project-value="${o.id}"
                onclick="taskManager.filterProjects(event, 'project-value', 'projects-dropdown', ${o.id})"
            >
                ${o.name}
            </li>
        `).join("");e.innerHTML=s}templateTasks(e,t,s){return`
                <div class="bg-white border border-[#7D7D7D] h-fit px-3 py-4 rounded-md mb-2"
                    id="task-${e.id}" draggable="true" ondragstart="taskManager.drag(event)"
                    data-task-id="${e.id}" data-project-id="${t.id}" onclick="taskManager.modalShow(${t.id}, ${e.id})">
                    <div class="flex justify-between items-start">
                        <h4 class="font-semibold text-sm pb-4">${e.name}</h4>
                        <p class="text-[10px] font-medium px-2 py-[2px] rounded-md text-white"
                            style="background-color: ${e.task_level.color}">${e.task_level.name}</p>
                    </div>
                    <p class="text-xs mb-3">${t.name}</p>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-500 font-medium flex items-center">
                            <svg class="size-4 mr-1" viewBox="0 0 35 35" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M30.625 17.5V27.7083C30.625 28.4819 30.3177 29.2237 29.7707 29.7707C29.2237 30.3177 28.4819 30.625 27.7083 30.625H7.29167C6.51812 30.625 5.77625 30.3177 5.22927 29.7707C4.68229 29.2237 4.375 28.4819 4.375 27.7083V17.5H30.625ZM23.3333 4.375C23.7201 4.375 24.091 4.52865 24.3645 4.80214C24.638 5.07563 24.7917 5.44656 24.7917 5.83333V7.29167H27.7083C28.4819 7.29167 29.2237 7.59896 29.7707 8.14594C30.3177 8.69292 30.625 9.43479 30.625 10.2083V14.5833H4.375V10.2083C4.375 9.43479 4.68229 8.69292 5.22927 8.14594C5.77625 7.59896 6.51812 7.29167 7.29167 7.29167H10.2083V5.83333C10.2083 5.44656 10.362 5.07563 10.6355 4.80214C10.909 4.52865 11.2799 4.375 11.6667 4.375C12.0534 4.375 12.4244 4.52865 12.6979 4.80214C12.9714 5.07563 13.125 5.44656 13.125 5.83333V7.29167H21.875V5.83333C21.875 5.44656 22.0286 5.07563 22.3021 4.80214C22.5756 4.52865 22.9466 4.375 23.3333 4.375Z"/>
                            </svg>
                            ${new Date(e.created_at).toLocaleDateString("en-US",{month:"short",day:"numeric",year:"numeric"})}
                        </p>
                        <p class="text-xs text-gray-500">${s.user.name}</p>
                    </div>
                </div>
        `}destroyElement(){["todo","in_progress","review","completed"].forEach(e=>{const t=document.getElementById(e);t&&(t.innerHTML="")})}findProjectAndTask(e,t){const s=this.projects.find(n=>n.id===e);if(!s)return[null,null];const o=s.tasks.find(n=>n.id===t),a=s.employees.find(n=>n.id===o.assigned_project_employee.employee_id);return[s,o,a]}modalShow(e,t){const s=document.getElementById("modalShow"),o=document.getElementById("modalShowBody"),a=document.getElementById("editTaskBtn"),[n,d,l]=this.findProjectAndTask(e,t);if(!n||!d){console.error("Project or task not found");return}const i=a.cloneNode(!0);a.parentNode.replaceChild(i,a),i.addEventListener("click",()=>this.renderEditTask(d)),o.innerHTML=this.renderModalShow(n,d,l),s.classList.remove("hidden")}renderModalShow(e,t,s){const o=this.getTimelineData(t);return`
            <h1 class="text-3xl font-bold mb-3">${t.name}</h1>

            <div class="flex flex-col space-y-5 mt-4 w-full">
                <!-- Create a consistent grid layout with fixed widths -->
                <div class="mx-4 md:mx-12">
                    <div class="flex flex-col md:grid md:grid-cols-[minmax(150px,200px)_1fr] gap-2 md:gap-4">
                        <div class="flex space-x-4">
                            <svg class="w-5 h-5" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.99999 4.8095C11.0465 4.8095 11.895 3.9565 11.895 2.9045C11.895 1.8525 11.0465 1 9.99999 1C8.95349 1 8.10499 1.853 8.10499 2.905C8.10499 3.957 8.95349 4.8095 9.99999 4.8095ZM2.895 19.095C3.941 19.095 4.7895 18.2425 4.7895 17.1905C4.7895 16.1385 3.941 15.2855 2.8945 15.2855C1.848 15.2855 1 16.139 1 17.191C1 18.243 1.8485 19.096 2.895 19.096V19.095ZM17.105 19.095C18.1515 19.095 19 18.2425 19 17.1905C19 16.1385 18.1515 15.2855 17.105 15.2855C16.0585 15.2855 15.21 16.1385 15.21 17.1905C15.21 18.2425 16.0585 19.0955 17.105 19.0955V19.095Z" stroke="#7D7D7D" stroke-linejoin="round"/>
                                <path d="M14.5715 4.15771C15.9231 4.96048 17.0423 6.10148 17.8188 7.46831C18.5953 8.83515 19.0024 10.3807 19 11.9527C19 12.2417 18.9867 12.5269 18.96 12.8082M13.507 20.2882C12.3979 20.7594 11.205 21.0017 10 21.0007C8.756 21.0007 7.571 20.7472 6.493 20.2882M1.04001 12.8082C1.01312 12.524 0.999777 12.2387 1.00001 11.9532C0.997583 10.3812 1.40468 8.83565 2.18121 7.46881C2.95774 6.10198 4.07691 4.96098 5.42851 4.15821" stroke="#7D7D7D" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Status</span>
                        </div>
                        <div>
                            <p class="text-xs font-medium px-4 py-1 rounded-full text-white w-fit"
                                style="background-color: ${t.task_status.color}">${t.task_status.name}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 md:mx-12">
                        <div class="flex flex-col md:grid md:grid-cols-[minmax(150px,200px)_1fr] gap-2 md:gap-4">
                            <div class="flex space-x-4">
                                <svg class="w-5 h-5" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.72 1H17.28C17.4021 1 17.5 1.09789 17.5 1.22V17.78C17.5 17.9021 17.4021 18 17.28 18H0.72C0.597891 18 0.5 17.9021 0.5 17.78V1.22C0.5 1.09789 0.597892 1 0.72 1ZM5.58 15.4C5.95514 15.4 6.26 15.0951 6.26 14.72V4.28C6.26 3.90486 5.95514 3.6 5.58 3.6H3.78C3.40486 3.6 3.1 3.90486 3.1 4.28V14.72C3.1 15.0951 3.40486 15.4 3.78 15.4H5.58ZM9.9 9.1C10.2751 9.1 10.58 8.79514 10.58 8.42V4.28C10.58 3.90486 10.2751 3.6 9.9 3.6H8.1C7.72486 3.6 7.42 3.90486 7.42 4.28V8.42C7.42 8.79514 7.72486 9.1 8.1 9.1H9.9ZM14.22 10.72C14.5951 10.72 14.9 10.4151 14.9 10.04V4.28C14.9 3.90486 14.5951 3.6 14.22 3.6H12.42C12.0449 3.6 11.74 3.90486 11.74 4.28V10.04C11.74 10.4151 12.0449 10.72 12.42 10.72H14.22Z" stroke="#7D7D7D"/>
                                </svg>
                                <span>Project</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium">${e.name}</p>
                            </div>
                        </div>
                </div>

                <div class="mx-4 md:mx-12">
                    <div class="flex flex-col md:grid md:grid-cols-[minmax(150px,200px)_1fr] gap-2 md:gap-4">
                        <div class="flex space-x-4">
                            <svg class="w-5 h-5" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 2.3V2.8H13.5H15.3C16.5539 2.8 17.5 3.74614 17.5 5V6.3H0.5V5C0.5 3.74614 1.44614 2.8 2.7 2.8H4.5H5V2.3V1.4C5 1.24362 5.04994 1.15216 5.10105 1.10105C5.15216 1.04994 5.24362 1 5.4 1C5.55638 1 5.64784 1.04994 5.69895 1.10105C5.75006 1.15216 5.8 1.24362 5.8 1.4V2.3V2.8H6.3H11.7H12.2V2.3V1.4C12.2 1.24362 12.2499 1.15216 12.3011 1.10105C12.3522 1.04994 12.4436 1 12.6 1C12.7564 1 12.8478 1.04994 12.8989 1.10105C12.9501 1.15216 13 1.24362 13 1.4V2.3ZM2.7 18C1.44614 18 0.5 17.0539 0.5 15.8V9.1H17.5V15.8C17.5 17.0539 16.5539 18 15.3 18H2.7Z" stroke="#7D7D7D"/>
                            </svg>
                            <span>Timeline</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium">${o}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 md:mx-12">
                    <div class="flex flex-col md:grid md:grid-cols-[minmax(150px,200px)_1fr] gap-2 md:gap-4">
                        <div class="flex space-x-4">
                            <svg class="w-5 h-5" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.9844 3.4956C7.98436 5.109 6.67101 6.42235 5.05761 6.42235C3.44421 6.42235 2.13086 5.109 2.13086 3.4956C2.13086 1.8822 3.44424 0.568848 5.05761 0.568848C6.67098 0.568848 7.98439 1.8822 7.9844 3.49559V3.4956Z" stroke="#7D7D7D"/>
                                <path d="M15.8692 3.4956V3.49561C15.8692 5.10899 14.5558 6.42235 12.9424 6.42235C11.329 6.42235 10.0156 5.10899 10.0156 3.4956C10.0156 1.8822 11.329 0.568848 12.9424 0.568848C14.5558 0.568848 15.8692 1.8822 15.8692 3.4956Z" stroke="#7D7D7D"/>
                                <path d="M0.5 12.5803C0.5 10.0673 2.54544 8.02197 5.05874 8.02197C7.61187 8.02197 9.61705 10.0914 9.61705 12.5803V14.2959C9.61705 14.3704 9.55664 14.4308 9.48213 14.4308H0.634922C0.560416 14.4308 0.5 14.3704 0.5 14.2959V12.5803Z" stroke="#7D7D7D"/>
                                <path d="M11.4682 13.7475C11.489 12.2731 11.5129 10.5852 10.2828 8.8711C13.1996 6.75503 17.4994 8.80508 17.4994 12.5802V14.2958C17.4994 14.3703 17.439 14.4307 17.3645 14.4307H11.4584C11.4614 14.3861 11.463 14.3411 11.463 14.2958C11.463 14.1167 11.4656 13.9338 11.4682 13.7475Z" stroke="#7D7D7D"/>
                                </svg>
                            <span>Assignee</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium">${s.user.name}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 md:mx-12">
                    <div class="flex flex-col md:grid md:grid-cols-[minmax(150px,200px)_1fr] gap-2 md:gap-4">
                        <div class="flex space-x-4">
                            <svg class="w-5 h-5" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.500134 1.76934L0.500123 1.76855C0.497831 1.59597 0.527572 1.42542 0.586783 1.26735C0.64598 1.10932 0.732905 0.96831 0.84054 0.851706C0.948093 0.73519 1.07386 0.645651 1.20919 0.586156C1.34438 0.526721 1.48761 0.497888 1.63084 0.500121L1.63177 0.500134L8.5438 0.595135L8.54412 0.595139C9.0636 0.601951 9.56882 0.828586 9.94882 1.241L9.94915 1.24135L16.6867 8.53936C16.6867 8.53937 16.6867 8.53938 16.6867 8.53939C17.0214 8.90197 17.3224 9.43388 17.4442 9.9932C17.5677 10.5625 17.5052 11.1851 17.0774 11.6478L17.0771 11.6481L10.6987 18.5591C10.6987 18.5592 10.6987 18.5592 10.6986 18.5592C10.2831 19.0093 9.74563 19.0678 9.2539 18.9437C8.76055 18.8087 8.30473 18.5314 7.93616 18.1354C7.93596 18.1352 7.93575 18.135 7.93555 18.1347L1.20038 10.8373C1.20033 10.8372 1.20027 10.8372 1.20021 10.8371C0.818872 10.4234 0.595395 9.85727 0.587823 9.25716C0.587822 9.25709 0.587822 9.25703 0.587821 9.25696L0.500134 1.76934ZM5.52944 3.72606L5.52346 3.71958L5.51725 3.71332C5.29406 3.48801 4.99034 3.35796 4.66831 3.36412C4.34639 3.37027 4.04798 3.5117 3.83314 3.74444C3.61943 3.97596 3.50302 4.28064 3.49794 4.59254C3.49286 4.90442 3.59925 5.21262 3.80451 5.45126L3.81011 5.45777L3.81593 5.46409L4.46855 6.17209L4.46849 6.17215L4.47489 6.17884C4.69662 6.41063 5.00227 6.54668 5.32822 6.54345C5.65411 6.54022 5.95693 6.3982 6.17425 6.16255C6.39038 5.92819 6.5068 5.61906 6.50919 5.30345C6.51158 4.98786 6.39988 4.67705 6.18771 4.43929L6.18777 4.43925L6.18206 4.43307L5.52944 3.72606Z" stroke="#7D7D7D"/>
                            </svg>
                            <span>Label</span>
                        </div>
                        <div class="ml-9 md:ml-0 mt-1 md:mt-0 flex space-x-2">
                            <p class="text-xs font-medium px-2 py-1 rounded-full text-white"
                                style="background-color: ${t.task_level.color}">${t.task_level.name}</p>
                            <p class="text-xs font-medium px-2 py-1 rounded-full text-white bg-[#6FAEC9]">${s.role.name}</p>
                        </div>
                    </div>
                </div>
            </div>
        `}getTimelineData(e){let t;switch(e.task_status_id){case 1:t=new Date(e.created_at).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});break;case 2:t=new Date(e.time_log.started_at).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});break;case 3:const s=new Date(e.time_log.started_at),o=e.time_log.duration_seconds*1e3,a=new Date(s.getTime()+o).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});t=`${s.toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"})} - ${a}`;break;case 4:const n=new Date(e.time_log.started_at).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"}),d=new Date(e.time_log.ended_at).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});t=`${n} - ${d}`;break}return t}renderEditTask(e){const t=document.querySelector('meta[name="csrf-token"]').getAttribute("content");console.log(t);const s=document.getElementById("modalEdit"),o=document.getElementById("modalEditBody"),a=`
                <form action="/tasks/${e.id}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" id="_token" value="${t}">
                    <!-- Modal Body -->
                    <div class="py-2 px-8 space-y-3">
                        <!-- Task Name -->
                        <div class="space-y-1">
                            <label class="block text-sm text-gray-700" for="name">Task</label>
                            <input type="text" name="name" id="name" value="${e.name}"
                                class="w-full border text-black bg-primary-white px-3 py-1 text-sm rounded focus:outline-none">
                        </div>

                        <div>
                            <div class="flex items-center">
                                <label class="block text-sm text-gray-700 mr-3">Task Level</label>
                                <div class="flex space-x-4 items-center">
                                    <label class="flex items-center text-sm">
                                        <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="1"
                                            ${e.task_level_id===1?"checked":""}/> Low
                                    </label>
                                    <label class="flex items-center text-sm">
                                        <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="2"
                                            ${e.task_level_id===2?"checked":""}/> Medium
                                    </label>
                                    <label class="flex items-center text-sm">
                                        <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="3"
                                            ${e.task_level_id===3?"checked":""}/> High
                                    </label>
                                </div>
                            </div>
                            <p class="text-xs bg-primary-white py-1 px-3 rounded text-slate-600 mt-2 space-x-6">
                                <span class="task-level">Low</span> : &lt; 2 hours
                                <span class="task-level">Medium</span> : &lt; 6 hours
                                <span class="task-level">High</span> : &gt; 6 hours
                            </p>
                        </div>
                    </div>
                    <div class="flex w-full px-8 pt-3">
                        <button id="submitBtn" type="submit"
                            class="bg-primary-black w-full text-sm text-white px-4 py-2 rounded hover:bg-zinc-700">
                            Submit
                        </button>
                    </div>
                </form>
        `;o.innerHTML=a,s.classList.remove("hidden")}closeModalShow(e){document.getElementById(e).classList.add("hidden")}}document.addEventListener("DOMContentLoaded",()=>{window.taskManager=new c});
