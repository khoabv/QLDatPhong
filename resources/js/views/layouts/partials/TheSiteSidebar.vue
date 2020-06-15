<template>
  <div class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <div class="side-nav">
        <v-collapse accordion>

         <!-- <v-collapse-item active-url="#lichhopcuatoi">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-calendar-o"/>Lịch họp của tôi
            </a>
          </v-collapse-item>
          <v-collapse-item active-url="#booklichhoptheongay">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-th-large"/>Book lịch họp theo ngày
            </a>
          </v-collapse-item>
          <v-collapse-item active-url="#booklichhoptheophong">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-puzzle-piece"/>Book lịch họp theo phòng
            </a>
          </v-collapse-item>
          <v-collapse-item active-url="#phongdabook">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-rocket"/>Phòng đã book
            </a>
          </v-collapse-item>-->

          <v-collapse-item active-url="/admin/lichtrinh">
            <a slot="item-title" href="/admin/lichtrinh/all">
              <i class="icon-fa icon-fa-calendar-o"/>QUẢN LÝ LỊCH TRÌNH
            </a>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/cuochop">
            <a slot="item-title" href="/admin/cuochop/all">
              <i class="icon-fa icon-fa-calendar-o"/>QUẢN LÝ CUỘC HỌP
            </a>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/rooms">
            <a slot="item-title" href="/admin/rooms/all">
              <i class="icon-fa icon-fa-calendar-o"/>QUẢN LÝ PHÒNG HỌP
            </a>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/users">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-calendar-o"/>QUẢN TRỊ HỆ THỐNG
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <!--<router-link to="/admin/users/profile">
              Thông tin cá nhân
            </router-link>-->

            <router-link to="/admin/users/all">
              Quản lý người dùng
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/thongbao">
            <a slot="item-title" href="/admin/thongbao/all">
              <i class="icon-fa icon-fa-calendar-o"/>QUẢN LÝ THÔNG BÁO
            </a>
          </v-collapse-item>

        </v-collapse>
      </div>
    </div>
  </div>
</template>
