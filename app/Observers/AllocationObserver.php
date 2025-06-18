<?php

namespace App\Observers;

use App\Mail\SendMail;
use App\Models\Allocation;
use Illuminate\Support\Facades\Mail;

class AllocationObserver
{
    /**
     * Handle the Allocation "created" event.
     */
    public function created(Allocation $allocation): void
    {
        $employeeName = $allocation->employee->first_name . ' ' . $allocation->employee->last_name;
        $equipmentName = $allocation->equipment->name;

        Mail::to(config('mail.from.address'))->send(
            new SendMail($employeeName, $equipmentName, 'Checkout')
        );
    }

    /**
     * Handle the Allocation "updated" event.
     */
    public function updated(Allocation $allocation): void
    {
        if ($allocation->isDirty('return_date') && $allocation->return_date !== null) {
            $employeeName = $allocation->employee->first_name . ' ' . $allocation->employee->last_name;
            $equipmentName = $allocation->equipment->name;

            Mail::to(config('mail.from.address'))->send(
                new SendMail($employeeName, $equipmentName, 'Return')
            );
        }
    }

    /**
     * Handle the Allocation "deleted" event.
     */
    public function deleted(Allocation $allocation): void
    {
        //
    }

    /**
     * Handle the Allocation "restored" event.
     */
    public function restored(Allocation $allocation): void
    {
        //
    }

    /**
     * Handle the Allocation "force deleted" event.
     */
    public function forceDeleted(Allocation $allocation): void
    {
        //
    }
}
