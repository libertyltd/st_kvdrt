<header id="headLine">
    <a class="close_constructor" href="/" title="На главную">X</a>
    <ul class="header_menu">
        <li class="header_menu_item"
            v-bind:class="{ active: isStepAddress }">Адрес</li>
        <li class="header_menu_item"
            v-bind:class="{ active: isStepRooms, point: selectedRoom }"
            v-on:click="gotoRooms">Комнаты</li>
        <li class="header_menu_item"
            v-bind:class="{ active: isStepBathrooms, point: selectedBathroom }"
            v-on:click="gotoBathrooms">Санузел</li>
        <li class="header_menu_item"
            v-bind:class="{ active: isStepOptions}">Опции</li>
        <li class="header_menu_item"
            v-bind:class="{ active: isStepOrder }">Заявка</li>
    </ul>
    <div class="control_elements" id="controls">
        <span class="price"
              v-if="summ > 0">@{{ numberFormat }} р.</span>
        <button class="btn"
            v-on:click.prevent="next">Далее</button>
    </div>
</header>