import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthService from './services/auth'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

// Dashboard Admin
import Finance from './views/admin/dashboard/Finance.vue'

// Dashboard Public
import DashboardPublic from './views/public/dashboard'

// Layouts
import LayoutBasic from './views/layouts/LayoutBasic.vue'
import LayoutLogin from './views/layouts/LayoutLogin.vue'
import LayoutFront from './views/layouts/LayoutFront.vue'
import LayoutBasicPublic from './views/public/layouts/LayoutBasic.vue'

// Users
import Users from './views/admin/users/Users.vue'
import Profile from './views/admin/users/Profile.vue'
import UsersAdd from './views/admin/users/UsersAdd.vue'
import UsersEdit from './views/admin/users/UsersEdit.vue'

// Phòng họp
import PhongHop from './views/admin/phonghop/PhongHop'
import PhongHopAdd from './views/admin/phonghop/PhongHopAdd'
import PhongHopEdit from './views/admin/phonghop/PhongHopEdit'

//Phòng họp public
import PhongHopDetailPublic from './views/public/phonghop/PhongHopDetail'

//Lịch trình
import lichtrinh from './views/admin/lichtrinh/lichtrinh'
import lichtrinhAdd from './views/admin/lichtrinh/lichtrinhAdd'
import lichtrinhEdit from './views/admin/lichtrinh/lichtrinhEdit'
import lichtrinhChuyenNhuong from './views/admin/lichtrinh/lichtrinhChuyenNhuong'

//Lịch trình public
import lichtrinhAddPublic from './views/public/lichtrinh/LichTrinhAdd'
import lichtrinhPublic from './views/public/lichtrinh/lichtrinh'
import lichtrinhDetailPublic from './views/public/lichtrinh/lichtrinhDetail'
import lichtrinhChuyenNhuongPublic from './views/public/lichtrinh/lichtrinhChuyenNhuong'
import lichTrinhYeuCauNhuongPhongPublic from './views/public/lichtrinh/LichTrinhYeuCauNhuongPhong'
import lichTrinhYeuCauNhuongPhongDetailPublic from './views/public/lichtrinh/LichTrinhYeuCauNhuongPhongDetail'

//Cuộc họp public
import cuochopPublic from './views/public/cuochop/cuochop'
import cuochopAddPublic from './views/public/cuochop/cuochopAdd'
import cuochopEditPublic from './views/public/cuochop/cuochopEdit'
import cuochopDetailPublic from './views/public/cuochop/cuochopDetail'

//Cuộc họp admin
import cuochopAdmin from './views/admin/cuochop/cuochop'
import cuochopDetailAdmin from './views/admin/cuochop/cuochopDetail'

// Thông báo
import ThongBao from './views/admin/thongbao/ThongBao'
import ThongBaoDetail from './views/admin/thongbao/ThongBaoDetail'

// Thông báo public
import ThongBaoPublic from './views/public/thongbao/ThongBao'
import ThongBaoDetailPublic from './views/public/thongbao/ThongBaoDetail'

//Đổi mật khẩu cá nhân
import ChangeMyPass from './views/admin/users/ChangePass'

// // Settings
// import Settings from './views/admin/Settings.vue'

/*
 |--------------------------------------------------------------------------
 | Other
 |--------------------------------------------------------------------------|
 */

// Auth
import Login from './views/auth/Login.vue'
import Register from './views/auth/Register.vue'

import NotFoundPage from './views/errors/404.vue'
import NotPermisionPage from './views/errors/403.vue'

/*
 |--------------------------------------------------------------------------
 | Frontend Views
 |--------------------------------------------------------------------------|
 */

import Home from './views/front/Home.vue'

Vue.use(VueRouter)

const routes = [

  /*
   |--------------------------------------------------------------------------
   | Layout Routes for DEMO
   |--------------------------------------------------------------------------|
   */

  /*
   |--------------------------------------------------------------------------
   | Frontend Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    component: LayoutBasicPublic,
    meta: {
      requiresAuth: true
    },
    children: [
     /* {
        path: '/',
        component: DashboardPublic,
        name: 'dashboard'
      },*/

      {path: '/', redirect: '/datphong'},

      //Đổi mật khẩu cá nhân
      {
        path: '/changeMyPass',
        component: ChangeMyPass
      },
      //PHÒNG HỌP
      {
        path: 'rooms/detail/:id',
        component: PhongHopDetailPublic,
        props: (route) => ({
          batdau: route.query.batdau,
          ketthuc: route.query.ketthuc,
          ngaydatphong: route.query.ngaydatphong,
          tungay: route.query.tungay,
          denngay: route.query.denngay,
          isDinhki2: route.query.isDinhki2,
          thu: route.query.thu
        })
      },

      //ĐẶT PHÒNG
      {
        path: 'datphong',
        component: lichtrinhAddPublic
      },

      //LỊCH TRÌNH
      {
        path: 'lichtrinh/all',
        component: lichtrinhPublic
      },
      {
        path: 'lichtrinh/chuyennhuong/:id',
        component: lichtrinhChuyenNhuongPublic
      },
      {
        path: 'lichtrinh/yeucaunhuongphong/:id',
        component: lichTrinhYeuCauNhuongPhongPublic
      },
      {
        path: 'lichtrinh/yeucaunhuongphong/detail/:id',
        component: lichTrinhYeuCauNhuongPhongDetailPublic
      },
      {
        path: 'lichtrinh/detail/:id',
        component: lichtrinhDetailPublic
      },
      {
        path: 'lichtrinh/taocuochop/:id',
        component: cuochopAddPublic
      },

      //CUỘC HỌP
      {
        path: 'cuochop/all',
        component: cuochopPublic
      },
      {
        path: 'cuochop/add',
        component: cuochopAddPublic
      },
      {
        path: 'cuochop/edit/:id',
        component: cuochopEditPublic
      },
      {
        path: 'cuochop/detail/:id',
        component: cuochopDetailPublic
      },

      //Thông báo
      {
        path: 'thongbao/all',
        component: ThongBaoPublic
      },
      {
        path: 'thongbao/detail/:id',
        component: ThongBaoDetailPublic
      },

    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Admin Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: '/admin',
    component: LayoutBasic, // Change the desired Layout here
    meta: {
      requiresAuth: true,
      requiredRoleAdmin: true
    },
    children: [
      // Dashboard
      /*{
        path: '/',
        component: Finance
      },
      {
        path: 'dashboard/',
        component: Finance
      },*/

      {path: '/', redirect: '/admin/thongbao/all'},

      // Users
      {
        path: 'users/profile',
        component: Profile
      },
      {
        path: 'users/all',
        component: Users
      },
      {
        path: 'users/add',
        component: UsersAdd
      },
      {
        path: 'users/edit/:id',
        // eslint-disable-next-line no-undef
        component: UsersEdit
      },

      // Settings
      // {
      //   path: 'settings',
      //   component: Settings
      // },

      /* DaiCQ add component for app quan ly phong hop 28/03/2020 */
      // Phòng họp
      {
        path: 'rooms/all',
        component: PhongHop
      },
      {
        path: 'rooms/add',
        component: PhongHopAdd
      },
      {
        path: 'rooms/edit/:id',
        component: PhongHopEdit
      },

      //lịch trinh
      {
        path: 'lichtrinh/all',
        component: lichtrinh
      },
      {
        path: 'lichtrinh/add',
        component: lichtrinhAdd
      },
      {
        path: 'lichtrinh/edit/:id',
        component: lichtrinhEdit
      },
      {
        path: 'lichtrinh/chuyennhuong/:id',
        component: lichtrinhChuyenNhuong
      },

      //Cuộc họp
      {
        path: 'cuochop/all',
        component: cuochopAdmin
      },
      {
        path: 'cuochop/detail/:id',
        component: cuochopDetailAdmin
      },

      //Thông báo
      {
        path: 'thongbao/all',
        component: ThongBao
      },
      {
        path: 'thongbao/detail/:id',
        component: ThongBaoDetail
      },
      /* END DaiCQ add component for app quan ly phong hop 28/03/2020 */
    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Auth & Registration Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    component: LayoutLogin,
    children: [
      {
        path: 'login',
        component: Login,
        name: 'login'
      },
    ]
  },

  {
    path: 'admin/',
    component: LayoutLogin,
    children: [
      {
        path: 'login',
        component: Login,
        name: 'login'
      },
      {
        path: 'register',
        component: Register,
        name: 'register'
      }
    ]
  },

  // Demo Pages
  {
    path: '/admin/pages',
    component: LayoutLogin,
    children: [
      {
        path: 'login',
        component: Login
      },
      {
        path: 'register',
        component: Register
      }
    ]
  },

  //  DEFAULT ROUTE
  /* { path: '*', component: NotFoundPage }*/
  {
    path: '*',
    component: NotFoundPage,
    children: [
      {
        path: '404',
        component: NotFoundPage
      }
    ]
  },

  {
    path: '403',
    component: NotPermisionPage,
  }

]

const router = new VueRouter({
  routes,
  mode: 'history',
  linkActiveClass: 'active'
})

router.beforeEach((to, from, next) => {
  //  If the next route is requires user to be Logged IN
  if (to.matched.some(m => m.meta.requiresAuth)) {
    return AuthService.check().then(authenticated => {
      if (!authenticated) {
        return next({path: '/login'})
      } else if (to.matched.some(m => m.meta.requiredRoleAdmin)) {
        return AuthService.isAdmin().then(isAdmin => {
          if (!isAdmin) {
            return next({path: '/403'})
          }
          return next()
        })
      }

      return next()
    })
  }

  return next()
})

export default router
