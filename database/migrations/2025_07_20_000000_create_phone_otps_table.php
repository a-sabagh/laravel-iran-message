 <?php

    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phone_otps', function (Blueprint $table) {
            $table->mediumInteger('country_code')->default(98);
            $table->string('phone_no', 20);
            $table->string('code', 255);
            $table->dateTime('available_in')->default(now()->addMinutes(2));

            $table->primary(['country_code', 'phone_no']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_otps');
    }
};
