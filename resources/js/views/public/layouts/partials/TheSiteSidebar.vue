<template>
  <div class="sidebar-left-public">
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
          <!--<v-collapse-item active-url="/admin/lichtrinh">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-shield"/>LỊCH TRÌNH CỦA BẠN
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/admin/lichtrinh/all">
              Lịch trình
            </router-link>
          </v-collapse-item>-->
          <v-collapse-item active-url="/datphong">
            <a slot="item-title" href="/datphong">
              <i class="icon-fa icon-fa-calendar-o"/>ĐẶT PHÒNG
            </a>
          </v-collapse-item>

          <v-collapse-item active-url="/lichtrinh">
            <a slot="item-title" href="/lichtrinh/all">
              <i class="icon-fa icon-fa-calendar-o"/>LỊCH TRÌNH CỦA BẠN
            </a>
          </v-collapse-item>

          <v-collapse-item active-url="/cuochop">
            <a slot="item-title" href="/cuochop/all">
              <i class="icon-fa icon-fa-calendar-o"/>CUỘC HỌP CỦA BẠN
            </a>
          </v-collapse-item>
          <!--<v-collapse-item active-url="/admin/rooms">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-shield"/>QUẢN LÝ PHÒNG HỌP
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/admin/rooms/all">
              Phòng họp
            </router-link>
          </v-collapse-item>-->

          <!--<v-collapse-item active-url="/admin/users">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-user"/>QUẢN TRỊ HỆ THỐNG
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            &lt;!&ndash;<router-link to="/admin/users/profile">
              Thông tin cá nhân
            </router-link>&ndash;&gt;

            <router-link to="/admin/users/all">
              Quản lý người dùng
            </router-link>
          </v-collapse-item>-->

          <v-collapse-item active-url="/thongbao">
            <a slot="item-title" href="/thongbao/all">
              <i class="icon-fa icon-fa-calendar-o"/>THÔNG BÁO <span style="color: red; font-weight: bold" v-if="countThongBao>0">({{countThongBao}})</span>
            </a>
          </v-collapse-item>

        </v-collapse>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">



  export default {
    data () {
      return {
        countThongBao:0
      }
    },
    created: function () {
      this.countThongBaoCuaToi(1)
    },
    methods: {
      async countThongBaoCuaToi () {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/thongbao/countThongBaoChuaDocCuaToi`)
          this.countThongBao = response.data.count
          /*$('#countThongBao').show();*/
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      }
    }
  }
</script>
