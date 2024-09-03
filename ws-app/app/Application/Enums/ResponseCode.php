<?php

namespace App\Application\Enums;

use Illuminate\Http\Response;

enum ResponseCode: int
{
    case CODE_100 = Response::HTTP_CONTINUE;
    case CODE_101 = Response::HTTP_SWITCHING_PROTOCOLS;
    case CODE_102 = Response::HTTP_PROCESSING;
    case CODE_200 = Response::HTTP_OK;
    case CODE_201 = Response::HTTP_CREATED;
    case CODE_202 = Response::HTTP_ACCEPTED;
    case CODE_203 = Response::HTTP_NON_AUTHORITATIVE_INFORMATION;
    case CODE_204 = Response::HTTP_NO_CONTENT;
    case CODE_205 = Response::HTTP_RESET_CONTENT;
    case CODE_206 = Response::HTTP_PARTIAL_CONTENT;
    case CODE_207 = Response::HTTP_MULTI_STATUS;
    case CODE_208 = Response::HTTP_ALREADY_REPORTED;
    case CODE_226 = Response::HTTP_IM_USED;
    case CODE_300 = Response::HTTP_MULTIPLE_CHOICES;
    case CODE_301 = Response::HTTP_MOVED_PERMANENTLY;
    case CODE_302 = Response::HTTP_FOUND;
    case CODE_303 = Response::HTTP_SEE_OTHER;
    case CODE_304 = Response::HTTP_NOT_MODIFIED;
    case CODE_305 = Response::HTTP_USE_PROXY;
    case CODE_306 = Response::HTTP_RESERVED;
    case CODE_307 = Response::HTTP_TEMPORARY_REDIRECT;
    case CODE_308 = Response::HTTP_PERMANENTLY_REDIRECT;
    case CODE_400 = Response::HTTP_BAD_REQUEST;
    case CODE_401 = Response::HTTP_UNAUTHORIZED;
    case CODE_402 = Response::HTTP_PAYMENT_REQUIRED;
    case CODE_403 = Response::HTTP_FORBIDDEN;
    case CODE_404 = Response::HTTP_NOT_FOUND;
    case CODE_405 = Response::HTTP_METHOD_NOT_ALLOWED;
    case CODE_406 = Response::HTTP_NOT_ACCEPTABLE;
    case CODE_407 = Response::HTTP_PROXY_AUTHENTICATION_REQUIRED;
    case CODE_408 = Response::HTTP_REQUEST_TIMEOUT;
    case CODE_409 = Response::HTTP_CONFLICT;
    case CODE_410 = Response::HTTP_GONE;
    case CODE_411 = Response::HTTP_LENGTH_REQUIRED;
    case CODE_412 = Response::HTTP_PRECONDITION_FAILED;
    case CODE_413 = Response::HTTP_REQUEST_ENTITY_TOO_LARGE;
    case CODE_414 = Response::HTTP_REQUEST_URI_TOO_LONG;
    case CODE_415 = Response::HTTP_UNSUPPORTED_MEDIA_TYPE;
    case CODE_416 = Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE;
    case CODE_417 = Response::HTTP_EXPECTATION_FAILED;
    case CODE_418 = Response::HTTP_I_AM_A_TEAPOT;
    case CODE_421 = Response::HTTP_MISDIRECTED_REQUEST;
    case CODE_422 = Response::HTTP_UNPROCESSABLE_ENTITY;
    case CODE_423 = Response::HTTP_LOCKED;
    case CODE_424 = Response::HTTP_FAILED_DEPENDENCY;
    case CODE_425 = Response::HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL;
    case CODE_426 = Response::HTTP_UPGRADE_REQUIRED;
    case CODE_428 = Response::HTTP_PRECONDITION_REQUIRED;
    case CODE_429 = Response::HTTP_TOO_MANY_REQUESTS;
    case CODE_431 = Response::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE;
    case CODE_451 = Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
    case CODE_500 = Response::HTTP_INTERNAL_SERVER_ERROR;
    case CODE_501 = Response::HTTP_NOT_IMPLEMENTED;
    case CODE_502 = Response::HTTP_BAD_GATEWAY;
    case CODE_503 = Response::HTTP_SERVICE_UNAVAILABLE;
    case CODE_504 = Response::HTTP_GATEWAY_TIMEOUT;
    case CODE_505 = Response::HTTP_VERSION_NOT_SUPPORTED;
    case CODE_506 = Response::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL;
    case CODE_507 = Response::HTTP_INSUFFICIENT_STORAGE;
    case CODE_508 = Response::HTTP_LOOP_DETECTED;
    case CODE_510 = Response::HTTP_NOT_EXTENDED;
    case CODE_511 = Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED;
}
