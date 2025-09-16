<?php

namespace App\Exports;

use App\Models\Membership;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembershipsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Membership::with(['networks', 'focalPoints', 'applications'])->get()->map(function ($m) {
            return [
                'ID'                   => $m->id,
                'NGO Name'             => $m->ngo_name ?? 'N/A',
                'Director Name'        => $m->director_name ?? 'N/A',
                'Director Phone'       => $m->director_phone ?? 'N/A',
                'Director Email'       => $m->director_email ?? 'N/A',
                'Alternate Name'       => $m->alt_name ?? 'N/A',
                'Alternate Phone'      => $m->alt_phone ?? 'N/A',
                'Alternate Email'      => $m->alt_email ?? 'N/A',
                'Membership Status'    => $m->membership_status ? 'Yes' : 'No',
                'More Info'            => is_null($m->more_info) ? 'N/A' : ($m->more_info ? 'Yes' : 'No'),
                'User ID'              => $m->user_id,

                // Networks comma separated
                'Networks'             => $m->networks->pluck('network_name')->implode(', '),

                // Focal Points: name (position) separated by semicolon
                'Focal Points'         => $m->focalPoints->map(fn($fp) => "{$fp->name} ({$fp->position})")->implode('; '),

                'Applications Count'   => $m->applications->count(),

                // Applications details summarized
                'Applications Details' => $m->applications->map(function ($app) {
                    $commChannels = is_array($app->comm_channels) ? implode(', ', $app->comm_channels) : '';
                    $commPhones = is_array($app->comm_phones) ? implode(', ', $app->comm_phones) : '';

                    return "Date: " . ($app->date?->format('Y-m-d') ?? 'N/A') .
                           "; Mailing Address: " . ($app->mailing_address ?? 'N/A') .
                           "; Facebook: " . ($app->facebook ?? 'N/A') .
                           "; Website: " . ($app->website ?? 'N/A') .
                           "; Comm Channels: " . $commChannels .
                           "; Comm Phones: " . $commPhones .
                           "; Vision: " . ($app->vision ?? 'N/A') .
                           "; Mission: " . ($app->mission ?? 'N/A') .
                           "; Goal: " . ($app->goal ?? 'N/A');
                })->implode(' || '),

                // File upload URLs or N/A (using asset helper for public storage path)
                'Letter'               => $m->applications->map(fn($app) => $app->letter ? asset('storage/' . $app->letter) : 'N/A')->implode(' | '),
                'Constitution'         => $m->applications->map(fn($app) => $app->constitution ? asset('storage/' . $app->constitution) : 'N/A')->implode(' | '),
                'Activities'           => $m->applications->map(fn($app) => $app->activities ? asset('storage/' . $app->activities) : 'N/A')->implode(' | '),
                'Funding'              => $m->applications->map(fn($app) => $app->funding ? asset('storage/' . $app->funding) : 'N/A')->implode(' | '),
                'Registration'         => $m->applications->map(fn($app) => $app->registration ? asset('storage/' . $app->registration) : 'N/A')->implode(' | '),
                'Strategic Plan'       => $m->applications->map(fn($app) => $app->strategic_plan ? asset('storage/' . $app->strategic_plan) : 'N/A')->implode(' | '),
                'Fundraising Strategy' => $m->applications->map(fn($app) => $app->fundraising_strategy ? asset('storage/' . $app->fundraising_strategy) : 'N/A')->implode(' | '),
                'Audit Report'         => $m->applications->map(fn($app) => $app->audit_report ? asset('storage/' . $app->audit_report) : 'N/A')->implode(' | '),
                'Signature'            => $m->applications->map(fn($app) => $app->signature ? asset('storage/' . $app->signature) : 'N/A')->implode(' | '),

                'Created At'           => $m->created_at?->format('d M Y') ?? 'N/A',
                'Updated At'           => $m->updated_at?->format('d M Y') ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'NGO Name',
            'Director Name',
            'Director Phone',
            'Director Email',
            'Alternate Name',
            'Alternate Phone',
            'Alternate Email',
            'Membership Status',
            'More Info',
            'User ID',
            'Networks',
            'Focal Points',
            'Applications Count',
            'Applications Details',
            'Letter',
            'Constitution',
            'Activities',
            'Funding',
            'Registration',
            'Strategic Plan',
            'Fundraising Strategy',
            'Audit Report',
            'Signature',
            'Created At',
            'Updated At',
        ];
    }
}
