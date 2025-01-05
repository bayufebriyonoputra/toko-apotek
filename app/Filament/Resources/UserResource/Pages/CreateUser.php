<?php

namespace App\Filament\Resources\UserResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
