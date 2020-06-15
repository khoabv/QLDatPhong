<?php


namespace App\SERVICES;


use App\Mail\DemoMail;
use Mail;

class MailService
{

    public static function sendMail($mailTo, $content, $title){
        $mailTo = "";
       /* $input = $request->all();*/
        Mail::to('daicq.dev@gmail.com')->send(new DemoMail());
       /* return view('home');*/
        /*Mail::to('krunal@appdividend.com')->send(new DemoMail($name));*/

        Mail::send('mailfb', array('name'=>'noi dung ten','email'=>'noi dung email', 'content'=>'content của email'), function($message){
            $message->to('daicq.dev@gmail.com', 'Hệ thống quản lý đặt phòng')->subject('Bạn có lịch họp mới!');
        });

        /*Mail::to($mailTo)
            ->cc('alone01011991@gmail.com')
            ->bcc('alone02021992@gmail.com')
            ->queue($message);*/

        /*Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to($mailTo, 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });*/
    }
}
