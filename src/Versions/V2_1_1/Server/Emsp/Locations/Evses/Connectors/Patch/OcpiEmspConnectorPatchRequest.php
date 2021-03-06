<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\BaseConnectorUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Psr\Http\Message\RequestInterface;
use UnexpectedValueException;

class OcpiEmspConnectorPatchRequest extends BaseConnectorUpdateRequest
{
    private PartialConnector $partialConnector;

    public function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/connectorPatch.schema.json', $this->jsonBody);
        $partialConnector = PartialConnectorFactory::fromJson($this->jsonBody);
        if ($partialConnector === null) {
            throw new UnexpectedValueException('PartialConnector cannot be null');
        }
        $this->partialConnector = $partialConnector;
    }

    public function getPartialConnector(): PartialConnector
    {
        return $this->partialConnector;
    }
}
