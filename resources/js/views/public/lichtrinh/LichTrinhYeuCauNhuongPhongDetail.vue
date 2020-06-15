<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Yêu cầu nhượng phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Lịch trình của bạn</a></li>
        <li class="breadcrumb-item"><a href="#">Yêu cầu nhượng phòng</a></li>
      </ol>

    </div>
    <div class="card">
      <div class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Mã lịch trình:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.malichtrinh}}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Phòng số</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataDetail.idphong" class="custom-select" disabled>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2" disabled="">
              <label class="bold">Người đặt</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataDetail.idnguoidat" class="custom-select" disabled>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Thời gian từ:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.batdau}}
            </div>
            <div class="form-group col-md-2">
              <label class="bold">đến:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.ketthuc}}
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Ngày đặt:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.ngaydatphong}}
            </div>
          </div>
        </div>

        <div class="row" v-if="isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Thời gian từ ngày:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.tungay}}

            </div>
            <div class="form-group col-md-2">
              <label class="bold">đến ngày:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.denngay}}

            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==true" >
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2"></div>

            <div class="form-group col-md-1">

              <input type="checkbox" name="thu" value="2" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 2
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="3" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 3
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="4" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 4
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="5" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 5
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="6" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 6
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="7" placeholder="" disabled
                     v-model="dataDetail.thu">Thứ 7
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="CN" placeholder="" disabled
                     v-model="dataDetail.thu">Chủ nhật
            </div>

          </div>
        </div>


        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="bold">Loại lịch trình:</label>
            </div>
            <div class="form-group col-md-3">
              {{isDinhki?'Định kỳ':'Không định kỳ'}}
            </div>

            <!--<div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="isDinhki" disabled>Định kì
            </div>-->
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2" disabled="">
              <label class="bold">Người yêu cầu nhượng phòng</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataDetail.idnguoiyeucau" class="custom-select" disabled>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2" disabled="">
              <label class="bold">Lý do yêu cầu nhượng phòng</label>
            </div>
            <div class="form-group col-md-6">
              <textarea rows="3" class="form-control"
                        v-model="dataDetail.lydo" disabled></textarea>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2" disabled="">
              <label class="bold">Trạng thái</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.trangthai==1?'Chờ duyệt':dataDetail.trangthai==2?'Đã duyệt':dataDetail.trangthai==3?'Từ chối':'Khác'}}
            </div>
          </div>
        </div>

        <!--<div  class="form-group">
          <label class="required">Mô tả</label>
          <textarea rows="3" class="form-control"
                    v-model="dataAdd.mo_ta"></textarea>
        </div>-->

        <div class="form-row center">

          <button v-if="userLoggedOn.id==dataDetail.idnguoidat && dataDetail.trangthai==0" class="btn btn-success" @click="dongYNhuongPhong()">
            Đồng ý nhượng phòng
          </button>
          <button v-if="userLoggedOn.id==dataDetail.idnguoidat && dataDetail.trangthai==0" class="btn btn-success" @click="huyYeuCauNhuongPhong()">
            Từ chối nhượng phòng
          </button>
          <!--<button v-if="userLoggedOn.id==dataDetail.idnguoiyeucau" class="btn btn-success" @click="huyYeuCauNhuongPhong()">
            Hủy yêu cầu nhượng phòng
          </button>-->
          <router-link to="/lichtrinh/all">
            <a class="btn btn-secondary">
              Thoát
            </a>
          </router-link>

        </div>
        <div class="line line-lg"></div>
      </div>
    </div>


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';

  export default {
    /* name: 'UsersAdd', */
    data() {
      return {
      /*  dataDetail: {
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
        },*/
        dataDetail: {
          id:'',
          idlichtrinh: '',
          idnguoidat: '',
          idnguoiyeucau:'',
          lydo: '',
          trangthai:'',

          idphong:'',
          malichtrinh: '',
          batdau: '',
          ketthuc: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
        },
        isDinhki: false,
        message: {
          lydo: ''
        },
        listphong: [],
        listnguoidat: [],
        userLoggedOn: {},
      }
    },
    created: function () {
      this.getUserLoggedOn();
      this.getYeuCauNhuongPhongById(this.$route.params.id);
      this.loadphong();

    },
    components: {datetime},
    methods: {
      async getUserLoggedOn () {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/auth/getUserLoggedOn`)
          this.userLoggedOn = response.data.user
          console.log("id user logged on = " + this.userLoggedOn.id)
          this.searchCondition.idNguoiDat = this.userLoggedOn.id
          this.loadPage(1)
        } catch (error) {
          if (error) {
            console.log("loi tai ham getUserLoggedOn()")
          //  window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }},
      async getYeuCauNhuongPhongById (id) {
        console.log("getYeuCauNhuongPhongById()")
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/lichtrinh/yeucaunhuongphong/getYeuCauChuyenNhuongByIdAndLichTrinh/${id}`)
          this.dataDetail = response.data.data
          if(response.data.loailichtrinh===0) this.isDinhki = false;
          else this.isDinhki = true;
          console.log("lydo yeu cau = "+this.dataDetail.lydo)

          console.log("lydo yeu cau response.data = "+response.datal.lydo)
        } catch (error) {
          console.log(console.log("loi tai ham getYeuCauNhuongPhongById()"))
          if (error) {
          //  window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async dongYNhuongPhong() {
        this.dataDetail.isDinhki = this.isDinhki;
        let response = await axios.post('/api/lichtrinh/duyetyeucaunhuongphong', this.dataDetail)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')

      },
      async huyYeuCauNhuongPhong() {
        this.dataDetail.isDinhki = this.isDinhki;
        let response = await axios.post('/api/lichtrinh/huyYeuCauNhuongPhong', this.dataDetail)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/lichtrinh/all'
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
        console.log('is dinhky = '+this.dataDetail.isDinhki)
        if (this.dataDetail.isDinhki == false) {

        }
      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }

    }
  }


</script>
