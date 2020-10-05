		<div class="d-flex justify-content-center">
			<h1>Список задач</h1>
		</div>
		<div class="d-flex justify-content-center">
			<h5>Сортировка</h5>
		</div>
		<div class="w-75 mx-auto d-flex flex-row mb-3 justify-content-center">
			
			<div id="filter_user" onclick="set_filter(this)" class="filter_button flex-fill user-select-none bd-highlight
										<?php 
										if ($data['filters']['user'] > 0) { echo ' bg-success'; } else { echo ' bg-secondary'; }
										?>
										 border border-dark rounded-left text-center text-white flex-nowrap">
				пользователь
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" 
										<?php 
										if ($data['filters']['user'] != 1) { echo ' hidden'; }
										?>
										fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 9.646a.5.5 0 0 1 .708 0L8 12.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/>
					<path fill-rule="evenodd" d="M8 2.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V3a.5.5 0 0 1 .5-.5z"/>
				</svg>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" 
					 					<?php 
										if ($data['filters']['user'] != 2) { echo ' hidden'; }
										?>
					 					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"/>
					<path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 1 1-.708-.708l3-3z"/>
				</svg>
			</div>
			
			<div id="filter_mail" onclick="set_filter(this)" class="filter_button flex-fill user-select-none bd-highlight
										<?php 
										if ($data['filters']['mail'] > 0) { echo ' bg-success'; } else { echo ' bg-secondary'; }
										?>
										 border-bottom border-top border-dark text-center text-white flex-nowrap">
				эл. почта
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" 
										<?php 
										if ($data['filters']['mail'] != 1) { echo ' hidden'; }
										?>
										fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 9.646a.5.5 0 0 1 .708 0L8 12.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/>
					<path fill-rule="evenodd" d="M8 2.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V3a.5.5 0 0 1 .5-.5z"/>
				</svg>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" 
					 					<?php 
										if ($data['filters']['mail'] != 2) { echo ' hidden'; }
										?>
										fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"/>
					<path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 1 1-.708-.708l3-3z"/>
				</svg>
			</div>
										 
			<div id="filter_done" onclick="set_filter(this)" class="filter_button flex-fill user-select-none bd-highlight
										<?php 
										if ($data['filters']['done'] > 0) { echo ' bg-success'; } else { echo ' bg-secondary'; }
										?>
										border border-dark rounded-right text-center text-white flex-nowrap">
				готовность
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" 
					 					<?php 
										if ($data['filters']['done'] != 1) { echo ' hidden'; }
										?>
					 					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M4.646 9.646a.5.5 0 0 1 .708 0L8 12.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/>
					<path fill-rule="evenodd" d="M8 2.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V3a.5.5 0 0 1 .5-.5z"/>
				</svg>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" 
					 					<?php 
										if ($data['filters']['done'] != 2) { echo ' hidden'; }
										?>
					 					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"/>
					<path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 1 1-.708-.708l3-3z"/>
				</svg>
			</div>
			
		</div>