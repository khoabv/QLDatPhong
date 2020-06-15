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
      <form @submit.prevent="validateBeforeSubmit" class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Mã lịch trình:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.malichtrinh}}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Phòng số</label>
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
              <label>Người đặt</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="idnguoidat" class="custom-select" disabled>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.batdau}}
            </div>
            <div class="form-group col-md-2">
              <label>đến:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.ketthuc}}
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Ngày đặt:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.ngaydatphong}}
            </div>
          </div>
        </div>

        <div class="row" v-if="isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ ngày:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.tungay}}

            </div>
            <div class="form-group col-md-2">
              <label>đến ngày:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataDetail.denngay}}

            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==true" >
          <div class="form-row col-md-12 margin">

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
              <label>Loại lịch trình:</label>
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
            <div class="form-group col-md-2">
              <label>Lý do yêu cầu nhượng phòng:</label>
            </div>
            <div class="form-group col-md-10">
              <textarea rows="3" class="form-control"
                        v-model="dataYeuCauNhuongPhong.lydo"></textarea>

            </div>

          </div>
        </div>

        <!--<div  class="form-group">
          <label class="required">Mô tả</label>
          <textarea rows="3" class="form-control"
                    v-model="dataAdd.mo_ta"></textarea>
        </div>-->

        <div class="row">
          <div class="form-row center">

            <button class="btn btn-success">
              Gửi
            </button>
            <router-link to="/datphong">
              <a class="btn btn-secondary">
                Hủy
              </a>
            </router-link>

          </div>
        </div>


        <div class="line line-lg"></div>
      </form>
    </div>


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';

  export default {
    /* name: 'UsersAdd', */
    data() {
      return {
        dataDetail: {
          id:'',
          malichtrinh: '',
          batdau: '',
          ketthuc: '',
          idphong: '',
          ngaydatphong: '',
          tennguoidat: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
        },
        dataYeuCauNhuongPhong: {
          idphong:'',
          idlichtrinh: '',
          idnguoidat: '',
          lydo: ''
        },
        idnguoidat:"",
        isDinhki: false,
        message: {
          lydo: ''
        },
        listphong: [],
        listnguoidat: []
      }
    },
    created: function () {
      this.getLichTrinhById(this.$route.params.id);
      this.loadphong();

    },
    components: {datetime},
    methods: {
      async getLichTrinhById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get/${id}`)
          this.idnguoidat = response.data.idnguoidat
          this.dataDetail = response.data
          this.dataDetail.ngaydatphong = response.data.ngaybatdau
          console.log('data ngaydatphong get by id = '+this.dataDetail.ngaydatphong);
          this.dataDetail.tungay = response.data.ngaybatdau
          console.log('data tungay get by id = '+this.dataDetail.ngaydatphong);
          this.dataDetail.denngay = response.data.ngayketthuc
          console.log('data denngay get by id = '+this.dataDetail.ngaydatphong);
          this.dataDetail.batdau = response.data.thoigianbatdau
          console.log('data batdau get by id = '+this.dataDetail.ngaydatphong);
          this.dataDetail.ketthuc = response.data.thoigianketthuc
          console.log('data ketthuc get by id = '+this.dataDetail.ketthuc);
          this.dataDetail.thu = response.data.thu.split(',');
          console.log('data thu get by id = '+this.dataDetail.thu);
          if(response.data.loailichtrinh===0) this.isDinhki = false;
          else this.isDinhki = true;
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async validateBeforeSubmit() {
        this.dataDetail.isDinhki = this.isDinhki;
        this.dataYeuCauNhuongPhong.idphong = this.dataDetail.idphong
        this.dataYeuCauNhuongPhong.idlichtrinh = this.dataDetail.id
        this.dataYeuCauNhuongPhong.idnguoidat = this.dataDetail.idnguoidat
        let response = await axios.post('/api/lichtrinh/yeucaunhuongphong', this.dataYeuCauNhuongPhong)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')

      }
      ,
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
        /*if (this.dataDetail.isDinhki === false) {
          this.dataDetail.isDinhki=true;
          //document.getElementById("chon_thu").style.display = 'block';
        }
        else {
          this.dataDetail.isDinhki=false;
          //document.getElementById("chon_thu").style.display = 'none';
        }*/
      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }

    }
  }


</script>
