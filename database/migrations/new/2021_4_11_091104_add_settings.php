<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('settings')->insert(
            array(
                array (
                    'key' => 'Terms',
                    'value' => '<blockquote style="color: rgb(50, 49, 48); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web (West European)&quot;, &quot;Segoe UI&quot;, -apple-system, BlinkMacSystemFont, Roboto, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; font-style: normal; margin: 0px 0px 0px 40px; border: none; padding: 0px;">
                    <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;">
                    <div style="margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, Arial, Helvetica, sans-serif; vertical-align: baseline; color: rgb(0, 0, 0);">
                    <p style="margin: 0px 0px 15px; text-align: right; color: rgb(51, 51, 51); box-sizing: border-box;"><span style="color: rgb(0, 0, 0); font-size: 12pt;">&nbsp;</span></p>
                    </div>
                    </blockquote>
                    </blockquote>

                    <div style="margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, Arial, Helvetica, sans-serif; vertical-align: baseline; color: rgb(0, 0, 0);">
                    <ul style="padding: 25px 20px; box-sizing: border-box; margin: 0px; font-size: 14px; line-height: 1.5; font-family: &quot;Noto Naskh Arabic&quot;, serif; list-style: none; direction: rtl; text-align: justify; color: rgb(80, 80, 80); background-color: rgb(245, 245, 245);">
                        <li style="box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">
                        <p style="margin: 0px 0px 15px; text-align: right; box-sizing: border-box;">يمكنك الاختيار ما بين الخيارات المتاحة ادناه للاشتراك في خدمة وفرلي:</p>

                        <ul style="box-sizing: border-box; margin: 0px; list-style: none;">
                            <li style="text-align: right; box-sizing: border-box; margin: 0px 20px 10px 18px; padding: 0px 0px 0px 18px; font-size: 14px; list-style: disc;">للاشتراك في النظام اليومي اطلب #92* او اتصل علي 920</li>
                        </ul>
                        </li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">يتمتع المستخدم الجديد ب 3 أيام مجانا عند تفعيل الخدمة. يرجى ملاحظة أنه إذا كنت تمتعت بالفعل بالفترة المجانية في الماضي، سيتم محاسبتك وفقا لنظام الاشتراك الذي قمت بتحديده.</li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">سيتم تجديد اشتراكك في خدمة البوابة الاسلامية تلقائيا، حتى تقوم بإلغاء تفعيل هذه الخدمة.</li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">اشتراكك في خدمة وفرلي، يعني موافقتك على استلام تنبيهات التجديد و التوصيات الخاصة بمحتوى الخدمة عن طريق الرسائل القصيرة.</li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">تطبق الرسوم على البيانات للتصفح ولتنزيل المحتويات المتاحة من هذه التطبيق.</li>
                        <li style="box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">
                        <p style="margin: 0px 0px 15px; text-align: right; box-sizing: border-box;">إذا كنت ترغب في تعطيل أو إلغاء الاشتراك من خدمة وفرلي&nbsp;برجاء اتباع التعليمات ادناه :</p>

                        <ul style="box-sizing: border-box; margin: 0px; list-style: none;">
                            <li style="text-align: right; box-sizing: border-box; margin: 0px 20px 10px 18px; padding: 0px 0px 0px 18px; font-size: 14px; list-style: disc;">لإلغاء النظام اليومي، برجاء طلب #0*92*</li>
                        </ul>
                        </li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">إذا كنت تستخدم جوال يعمل بنظام التشغيل IOS، تحميل الفيديوهات والنغمات غير متاح ، ولكن يمكنك تشغيلها والاستماع إليها على جهازك.</li>
                        <li style="text-align: right; box-sizing: border-box; margin: 0px 15px 20px 18px; padding: 0px 0px 0px 18px; font-size: 16px; list-style: square;">إذا لم تنجح المحاولات لتجديد إشتراكك لمدة 30 يوما متتاليا, فسيتم إلغاء تفعيل إشتراكك تلقائيا في اليوم الواحد و الثلاثين.</li>
                    </ul>
                    </div>
                    ',
                    'type_id' => 1,
                    'created_at' => '2017-07-27 10:59:22',
                    'updated_at' => '2017-08-15 12:40:04',
                ),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
