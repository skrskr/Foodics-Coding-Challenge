<?php

namespace App\Jobs;

use App\Mail\IngredientQuantityAlertMail;
use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmailToMerchantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ingredientIds = [];
    /**
     * Create a new job instance.
     */
    public function __construct(array $ingredientIds)
    {
        $this->ingredientIds = $ingredientIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ingredients = Ingredient::whereIn("id", $this->ingredientIds)->get();
        $merchantEmail = config('app.merchant_email');
        
        foreach ($ingredients as $ingredient) {
            $quanityPercentage = ($ingredient->available_quantity_in_grams / $ingredient->stock_capacity_in_grams) * 100;

            if ($quanityPercentage < 50) {
                $mailData = [
                    "name" => $ingredient->name,
                    "percentage" => $quanityPercentage
                ];
                Mail::to([$merchantEmail])->send(new IngredientQuantityAlertMail($mailData));
            }
        }
    }
}
