<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Chi tiết lịch trình đặt phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Lịch trình của bạn</a></li>
        <li class="breadcrumb-item"><a href="#">Chi tiết</a></li>
      </ol>

    </div>

    <div class="card">
      <div class="form">
        <div class="card-header">
          <h6>THÔNG TIN LỊCH TRÌNH</h6>
          <div class="card-actions"/>
        </div>
        <div class="card-body">
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
                <select v-model="dataUpdate.idphong" class="custom-select" disabled>
                  <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

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
                {{dataUpdate.batdau}}
              </div>
              <div class="form-group col-md-2">
                <label>đến:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataUpdate.ketthuc}}
              </div>
            </div>
          </div>
          <div class="row" v-if="isDinhki==false">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Ngày đặt:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataUpdate.ngaydatphong}}
              </div>
            </div>
          </div>

          <div class="row" v-if="isDinhki==true">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Thời gian từ ngày:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataUpdate.tungay}}

              </div>
              <div class="form-group col-md-2">
                <label>đến ngày:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataUpdate.denngay}}

              </div>
            </div>
          </div>
          <div class="row" v-if="isDinhki==true" >
            <div class="form-row col-md-12 margin">

              <div class="form-group col-md-1">

                <input type="checkbox" name="thu" value="2" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 2
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="3" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 3
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="4" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 4
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="5" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 5
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="6" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 6
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="7" placeholder="" disabled
                       v-model="dataUpdate.thu">Thứ 7
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="CN" placeholder="" disabled
                       v-model="dataUpdate.thu">Chủ nhật
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
          <div class="form-row center">
            <!--
                      <button class="btn btn-success">
                        Lưu
                      </button>-->
            <router-link to="/lichtrinh/all">
              <a class="btn btn-secondary">
                Quay lại
              </a>
            </router-link>

          </div>
        </div>


        <div class="line line-lg"></div>
      </div>
    </div>


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';
  import CommonJs from '../../../common'

  export default {
    /* name: 'UsersAdd', */
    data() {
      return {
        dataUpdate: {
          malichtrinh: '',
          batdau: '',
          ketthuc: '',
          ten_phong: '',
          ngaydatphong: '',
          tennguoidat: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
        },
        isDinhki: false,
        message: {
          ten_phong: '',
          mo_ta: '',
          trang_thai: '',
          loai_phong: '',
          soluong: '',
        },
        listphong: [],
        listnguoidat: [],
        pageThanhVien: CommonJs.page
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
          this.dataUpdate = response.data
          this.dataUpdate.ngaydatphong = response.data.ngaybatdau
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
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }

    }
  }


</script>
