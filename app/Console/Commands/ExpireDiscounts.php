<?php



namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;
use Illuminate\Support\Carbon;

class ExpireDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'discounts:expire';

    /**
     * The console command description.
     */
    protected $description = 'Automatically expire discounts that are past their expiration date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = Discount::where('status', 'active')
            ->where('expires_at', '<', Carbon::today())
            ->update(['status' => 'expired']);

        $this->info("Successfully expired {$expiredCount} discount(s).");
    }
}
