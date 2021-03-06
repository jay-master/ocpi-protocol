<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;

class OcpiEmspTokenPostResponse extends OcpiCreateResponse
{
    private AllowedType $allowed;

    private ?LocationReferences $location;

    private ?DisplayText $info;

    public function __construct(AllowedType $allowed, ?LocationReferences $location, ?DisplayText $info)
    {
        parent::__construct('Token successfully created.');
        $this->allowed = $allowed;
        $this->location = $location;
        $this->info = $info;
    }

    public function getData(): array
    {
        return [
            'allowed' => $this->allowed,
            'location' => $this->location,
            'info' => $this->info
        ];
    }
}
