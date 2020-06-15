<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Chỉnh sửa lịch trình đặt phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Chỉnh sửa lịch trình</a></li>
      </ol>

    </div>
    <div class="card">
      <form @submit.prevent="validateBeforeSubmit" class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Mã lịch trình:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataUpdate.malichtrinh}}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Phòng số</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataUpdate.ten_phong" class="custom-select">
                <option value="">Chọn phòng cần đặt</option>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
              <div class="message_invalid">
                {{ message.ten_phong }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label>Người đặt</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataUpdate.idnguoidat" class="custom-select">
                <option value="">Chọn người đặt phòng</option>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

              </select>
              <div class="message_invalid">
                {{ message.idnguoidat }}
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
              <!--<datetime format="H:i:s" v-model="dataUpdate.batdau"></datetime>-->
              <Select2 v-model="dataUpdate.batdau" :options="listTime"/>
              <div class="message_invalid">
                {{ message.batdau }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label>đến</label>
            </div>
            <div class="form-group col-md-3">
              <!--<datetime format="H:i:s" v-model="dataUpdate.ketthuc"></datetime>-->
              <Select2 v-model="dataUpdate.ketthuc" :options="listTime"/>
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
              <datetime format="YYYY-MM-DD" v-model="dataUpdate.ngaydatphong"></datetime>
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
             <!-- <datetime format="DD/MM/YYYY" v-model="dataUpdate.tungay"></datetime>-->
              <datetime format="YYYY-MM-DD" v-model="dataUpdate.tungay"></datetime>
              <div class="message_invalid">
                {{ message.tungay }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label>đến ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataUpdate.denngay"></datetime>
              <div class="message_invalid">
                {{ message.denngay }}
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==true" >
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-1">

              <input type="checkbox" name="thu" value="2" placeholder=""
                     v-model="dataUpdate.thu">Thứ 2
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="3" placeholder=""
                     v-model="dataUpdate.thu">Thứ 3
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="4" placeholder=""
                     v-model="dataUpdate.thu">Thứ 4
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="5" placeholder=""
                     v-model="dataUpdate.thu">Thứ 5
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="6" placeholder=""
                     v-model="dataUpdate.thu">Thứ 6
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="7" placeholder=""
                     v-model="dataUpdate.thu">Thứ 7
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="CN" placeholder=""
                     v-model="dataUpdate.thu">Chủ nhật
            </div>

          </div>
          <div class="message_invalid">
            {{ message.thu }}
          </div>
        </div>


        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder="Nhập tên phòng để tìm kiếm"
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

  import datetime from 'vuejs-datetimepicker';
  import Select2 from 'v-select2-component'
  import Constants from '../../../Constants'

  export default {
    /* name: 'UsersAdd', */
    components: {
      'Select2': Select2,
      datetime
    },
    data() {
      return {
        listTime:Constants.listTime,
        dataUpdate: {
          id:'',
          malichtrinh: '',
          batdau: '',
          ketthuc: '',
          ten_phong: '',
          ngaydatphong: '',
          idnguoidat: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
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
          idnguoidat:''
        },
        listphong: [],
        listnguoidat: []
      }
    },
    created: function () {
      this.getLichTrinhById(this.$route.params.id);
      this.loadphong();

    },

    methods: {
      async getLichTrinhById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get/${id}`)
          this.dataUpdate = response.data
          this.dataUpdate.ngaydatphong = response.data.ngaybatdau
          this.dataUpdate.ten_phong = response.data.idphong;
          console.log('data ngaydatphong get by id = '+this.dataUpdate.ngaydatphong);
          this.dataUpdate.tungay = response.data.ngaybatdau
          console.log('data tungay get by id = '+this.dataUpdate.ngaydatphong);
          this.dataUpdate.denngay = response.data.ngayketthuc
          console.log('data denngay get by id = '+this.dataUpdate.ngaydatphong);
          this.dataUpdate.batdau = response.data.thoigianbatdau
          console.log('data batdau get by id = '+this.dataUpdate.ngaydatphong);
          this.dataUpdate.ketthuc = response.data.thoigianketthuc
          console.log('data ketthuc get by id = '+this.dataUpdate.ketthuc);
          this.dataUpdate.thu = response.data.thu.split(',');
          console.log('data thu get by id = '+this.dataUpdate.thu);
          if(response.data.loailichtrinh===0) this.isDinhki = false;
          else this.isDinhki = true;
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async validateBeforeSubmit() {
        let isValid = this.validate();
        if(!isValid) return;
        this.checkTrungLichTrinh();
      },
      async validate () {
        this.message.ten_phong = ''
        this.message.batdau = ''
        this.message.ketthuc = ''
        this.message.ngaydatphong = ''
        this.message.tungay = ''
        this.message.denngay = ''
        this.message.thu = ''
        this.message.idnguoidat = ''
        let resultCheck = true;
        if (this.dataUpdate.ten_phong === '' || this.dataUpdate.ten_phong === null
          || typeof (this.dataUpdate.ten_phong) === 'undefined') {

          this.message.ten_phong = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.dataUpdate.batdau === '' || this.dataUpdate.batdau === null || typeof (this.dataUpdate.batdau) === 'undefined') {
          this.message.batdau = 'Trường không được để trống!'
          resultCheck = false
        }

        if (this.dataUpdate.ketthuc === '' || this.dataUpdate.ketthuc === null || typeof (this.dataUpdate.ketthuc) === 'undefined') {
          this.message.ketthuc = 'Trường không được để trống!'
          resultCheck = false
        }

        //xét nếu check dataAdd.batdau và dataAdd.ketthuc ở trên có valid -> check validate lệch time
        if(resultCheck){
          let arrTimeBatDau = this.dataUpdate.batdau.split(":");
          let arrTimeKetThuc = this.dataUpdate.ketthuc.split(":");
          let hourBatDau = parseInt(arrTimeBatDau[0]);
          let minuteBatDau = parseInt(arrTimeBatDau[1]);
          let hourKetThuc = parseInt(arrTimeKetThuc[0]);
          let minuteKetThuc = parseInt(arrTimeKetThuc[1]);
          if((hourBatDau > hourKetThuc) || ((hourBatDau == hourKetThuc) && (minuteBatDau >= minuteKetThuc))) {
            this.message.ketthuc = "Thời gian kết thúc phải lớn hơn thời gian bắt đầu!"
            resultCheck = false
          }
        }

        if (this.dataUpdate.idnguoidat === '' || this.dataUpdate.idnguoidat === null || typeof (this.dataUpdate.idnguoidat) === 'undefined') {
          this.message.idnguoidat = 'Trường không được để trống!'
          resultCheck = false
        }

        if(!this.isDinhki){
          if (this.dataUpdate.ngaydatphong === '' || this.dataUpdate.ngaydatphong === null || typeof (this.dataUpdate.ngaydatphong) === 'undefined') {
            this.message.ngaydatphong = 'Trường không được để trống!'
            resultCheck = false
          }
        }
        else {
          if (this.dataUpdate.tungay === '' || this.dataUpdate.tungay === null || typeof (this.dataUpdate.tungay) === 'undefined') {
            this.message.tungay = 'Trường không được để trống!'
            resultCheck = false
          }
          if (this.dataUpdate.denngay === '' || this.dataUpdate.denngay === null || typeof (this.dataUpdate.denngay) === 'undefined') {
            this.message.denngay = 'Trường không được để trống!'
            resultCheck = false
          }
          console.log("validate thu = "+this.dataUpdate.thu)
          if (this.dataUpdate.thu === '' || this.dataUpdate.thu.length==0 || this.dataUpdate.thu === null || typeof (this.dataUpdate.thu) === 'undefined') {
            this.message.thu = 'Chọn ít nhất 1 ngày trong tuần!'
            resultCheck = false
          }
        }
        return resultCheck
      },
      async submit(){
        this.dataUpdate.isDinhki = this.isDinhki;
        let response = await axios.post('/api/admin/lichtrinh/update', this.dataUpdate)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/admin/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')
      },
      async loadphong() {
        const dsphong = await axios.get(`/api/admin/rooms/danhsachphong`);
        this.listphong = dsphong.data.listphong;
        //this.searchCondition.isDinhki == false;
        const dsnguoidat = await axios.get('/api/admin/users/danhsachnguoidung');
        this.listnguoidat = dsnguoidat.data.nguoidat;
        console.log(this.listnguoidat);
        console.log(this.listphong);
      },
      async isdinhki() {
        console.log('is dinhky = '+this.dataUpdate.isDinhki)
        if (this.dataUpdate.isDinhki == false) {

        }
        /*if (this.dataUpdate.isDinhki === false) {
          this.dataUpdate.isDinhki=true;
          //document.getElementById("chon_thu").style.display = 'block';
        }
        else {
          this.dataUpdate.isDinhki=false;
          //document.getElementById("chon_thu").style.display = 'none';
        }*/
      },
      async checkTrungLichTrinh() {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/checkExistLichTrinh`, {
            params: {
              page: 1,
              idPhongHop: this.dataUpdate.ten_phong,
              batdau: this.dataUpdate.batdau,
              ketthuc: this.dataUpdate.ketthuc,
              ngaydatphong: this.dataUpdate.ngaydatphong,
              tungay: this.dataUpdate.tungay,
              denngay: this.dataUpdate.denngay,
              isDinhKi: this.isDinhki,
              thu: this.dataUpdate.thu
              
            }}
          )
          this.page = response.data
          if(this.page.items!=null && this.page.items.length>0 && this.page.items[0].id != this.dataUpdate.id) {
              window.toastr['error']('Lịch đặt này đã được đặt bởi người khác!', 'Error')
              return;

            /*this.isExistedLichTrinh = true;*/
          }

          //nếu không trùng lịch trình
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
