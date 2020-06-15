<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Danh sách lịch trình đặt phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Đặt phòng</a></li>
      </ol>

    </div>
    <div class="card">
      <form @submit.prevent="validateBeforeSubmit" class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
            <label>Loại phòng</label>
          </div>
            <div class="form-group col-md-3">
              <select v-model="searchRoom.loaiPhong" class="custom-select" @change="loadphong">
                <option value="">Tất cả</option>
                <option value="0">Hội thảo</option>
                <option value="1">Phỏng vấn</option>
                <option value="2">Họp</option>
                <option value="3">Đào tạo</option>
                <option value="4">Khác</option>

              </select>
            </div>

            <div class="form-group col-md-2">
              <label>Phòng số</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataAdd.ten_phong" class="custom-select">
                <option value="">Chọn phòng cần đặt</option>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
              <div class="message_invalid">
                {{ message.ten_phong }}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Người đặt</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataAdd.tennguoidat" class="custom-select">
                <option value="">Chọn người đặt phòng</option>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

              </select>
              <div class="message_invalid">
                {{ message.tennguoidat }}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ</label>
            </div>
            <div class="form-group col-md-3">
            <!--  <datetime format="H:i" v-model="dataAdd.batdau"></datetime>-->
              <Select2 v-model="dataAdd.batdau" :options="listTime"/>
              <div class="message_invalid">
                {{ message.batdau }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label>đến</label>
            </div>
            <div class="form-group col-md-3">
             <!-- <datetime format="H:i" v-model="dataAdd.ketthuc"></datetime>-->
              <Select2 v-model="dataAdd.ketthuc" :options="listTime"/>
              <div class="message_invalid">
                {{ message.ketthuc }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Ngày đặt</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataAdd.ngaydatphong"></datetime>
              <div class="message_invalid">
                {{ message.ngaydatphong }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>

        <div class="row" v-if="isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataAdd.tungay"></datetime>
              <div class="message_invalid">
                {{ message.tungay }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label>đến ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataAdd.denngay"></datetime>
              <div class="message_invalid">
                {{ message.denngay }}
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==true">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="2" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 2
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="3" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 3
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="4" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 4
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="5" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 5
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="6" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 6
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="7" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Thứ 7
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="CN" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="dataAdd.thu">Chủ nhật
            </div>

          </div>
          <div class="message_invalid">
            {{ message.thu }}
          </div>
        </div>
        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhkifn()" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="isDinhki">Định kì
            </div>
          </div>
        </div>
        <div class="form-row center">

          <button class="btn btn-success">
            Lưu
          </button>
          <router-link to="/admin/lichtrinh/all">
            <a class="btn btn-secondary">
              Hủy
            </a>
          </router-link>

        </div>
        <div class="line line-lg"></div>
      </form>
    </div>


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker'
  import Constants from '../../../Constants'
  import Select2 from 'v-select2-component';

  export default {
    /* name: 'UsersAdd', */
    components: {
      'Select2': Select2,
      datetime
    },
    data() {
      return {
        listTime:Constants.listTime,
        searchRoom: {
          loai_phong:''
        },
        dataAdd: {
          batdau: '',
          ketthuc: '',
          ten_phong: '',
          ngaydatphong: '',
          tennguoidat: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: ''

        },
        isDinhki: false,
        message: {
          ten_phong:'',
          batdau: '',
          ketthuc: '',
          ngaydatphong:'',
          tungay: '',
          denngay: '',
          thu: '',
          tennguoidat:''
        },
        listphong: [],
        listnguoidat: []
      }
    },
    created: function () {
      this.loadphong();

    },

    methods: {
      async validateBeforeSubmit() {
        this.dataAdd.isDinhki = this.isDinhki;
        let isValid = this.validate();
        if(!isValid) return;
        this.checkTrungLichTrinh()
       // this.submit();

      },
      validate () {
        this.message.ten_phong = ''
        this.message.batdau = ''
        this.message.ketthuc = ''
        this.message.ngaydatphong = ''
        this.message.tungay = ''
        this.message.denngay = ''
        this.message.thu = ''
        this.message.tennguoidat = ''
        let resultCheck = true;
        if (this.dataAdd.ten_phong === '' || this.dataAdd.ten_phong === null
          || typeof (this.dataAdd.ten_phong) === 'undefined') {

          this.message.ten_phong = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.dataAdd.ketthuc === '' || this.dataAdd.ketthuc === null
          || typeof (this.dataAdd.ketthuc) === 'undefined') {

          this.message.ketthuc = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.dataAdd.batdau === '' || this.dataAdd.batdau === null
          || typeof (this.dataAdd.batdau) === 'undefined') {
          this.message.batdau = 'Trường không được để trống!'
          resultCheck = false
        }

        if (this.dataAdd.ketthuc === '' || this.dataAdd.ketthuc === null
          || typeof (this.dataAdd.ketthuc) === 'undefined') {

          this.message.ketthuc = 'Trường không được để trống!'
          resultCheck = false
        }

        //xét nếu check dataAdd.batdau và dataAdd.ketthuc ở trên có valid -> check validate lệch time
        if(resultCheck){
          let arrTimeBatDau = this.dataAdd.batdau.split(":");
          let arrTimeKetThuc = this.dataAdd.ketthuc.split(":");
          let hourBatDau = parseInt(arrTimeBatDau[0]);
          let minuteBatDau = parseInt(arrTimeBatDau[1]);
          let hourKetThuc = parseInt(arrTimeKetThuc[0]);
          let minuteKetThuc = parseInt(arrTimeKetThuc[1]);
          if((hourBatDau > hourKetThuc) || ((hourBatDau == hourKetThuc) && (minuteBatDau >= minuteKetThuc))) {
            this.message.ketthuc = "Thời gian kết thúc phải lớn hơn thời gian bắt đầu!"
            resultCheck = false
          }
        }


        if (this.dataAdd.tennguoidat === '' || this.dataAdd.tennguoidat === null || typeof (this.dataAdd.tennguoidat) === 'undefined') {
          this.message.tennguoidat = 'Trường không được để trống!'
          resultCheck = false
        }

        if(!this.isDinhki){
          if (this.dataAdd.ngaydatphong === '' || this.dataAdd.ngaydatphong === null || typeof (this.dataAdd.ngaydatphong) === 'undefined') {
            this.message.ngaydatphong = 'Trường không được để trống!'
            resultCheck = false
          }
        }
        else {
          if (this.dataAdd.tungay === '' || this.dataAdd.tungay === null || typeof (this.dataAdd.tungay) === 'undefined') {
            this.message.tungay = 'Trường không được để trống!'
            resultCheck = false
          }
          if (this.dataAdd.denngay === '' || this.dataAdd.denngay === null || typeof (this.dataAdd.denngay) === 'undefined') {
            this.message.denngay = 'Trường không được để trống!'
            resultCheck = false
          }
          console.log("validate thu = "+this.dataAdd.thu)
          if (this.dataAdd.thu === '' || this.dataAdd.thu.length==0 || this.dataAdd.thu === null || typeof (this.dataAdd.thu) === 'undefined') {
            this.message.thu = 'Chọn ít nhất 1 ngày trong tuần!'
            resultCheck = false
          }
        }
        return resultCheck
      },

      async submit(){
        let response = await axios.post('/api/admin/lichtrinh/addlichtrinh', this.dataAdd)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/admin/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')
      },
      async loadphong() {
        const dsphong = await axios.get(`/api/admin/rooms/danhsachphong`,{
          params:{
            loaiPhong: this.searchRoom.loaiPhong
          }
        });
        this.listphong = dsphong.data.listphong;
        this.dataAdd.isDinhki == false;
        const dsnguoidat = await axios.get('/api/admin/users/danhsachnguoidung');
        this.listnguoidat = dsnguoidat.data.nguoidat;
        console.log(this.listnguoidat);
        console.log(this.listphong);
      },
      async isdinhkifn() {
        if (this.isDinhki == false) {

        }
      },
      async checkTrungLichTrinh() {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/checkExistLichTrinh`, {
            params: {
              page: 1,
              idPhongHop: this.dataAdd.ten_phong,
              batdau: this.dataAdd.batdau,
              ketthuc: this.dataAdd.ketthuc,
              ngaydatphong: this.dataAdd.ngaydatphong,
              tungay: this.dataAdd.tungay,
              denngay: this.dataAdd.denngay,
              isDinhKi: this.dataAdd.isDinhki,
              thu: this.dataAdd.thu

            }}
          )
          this.page = response.data
          console.log("items = "+this.page.items)
          if(this.page.items!=null && this.page.items.length>0) {
            window.toastr['error']('Lịch đặt này đã được đặt bởi người khác!', 'Error')
            return;
            /*this.isExistedLichTrinh = true;*/
          }

          else {
            /*this.isExistedLichTrinh = false;*/
            this.submit();
          }
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }

      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }


    }
  }


</script>
