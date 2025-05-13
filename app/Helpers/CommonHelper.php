<?php

namespace App\Helpers;

use App\Gateways\NotExist;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Auth\Entities\Otp;
use Modules\Order\App\Constant\OrderItemConstant;
use Modules\Order\App\Models\Order;
use Modules\Order\App\Models\OrderItem;
use Modules\Payment\App\Models\Payment;
use Modules\Voucher\Entities\Voucher;

class CommonHelper
{
    public static function buildRefundData(Order $order): array
    {
        return [
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'gateway_id' => $order->payment->gateway_id,
            'payment_id' => $order->payment->id,
            'amount' => self::getRefundAbleAmount($order)
        ];
    }

    public static function getRefundAbleAmount(Order $order)
    {
        if ($order->items->count() == $order->items->where('status', OrderItemConstant::FAILED)->count()) {
            return $order->total_payable;
        } else {
            return $order->items->where('status', OrderItemConstant::FAILED)->sum('total_price');
        }
    }

    public static function explode($value, $separator = ',', $isInteger = false): array
    {
        return array_filter(explode($separator, str_replace($separator . ' ', $separator, $value)), function ($item) use ($isInteger) {
            if ($isInteger) {
                return is_numeric($item);
            }
            return true;
        });
    }

    public static function isVoucher($name): bool
    {
        return strtolower($name) == 'vouchers';
    }

    public static function parseLocalizeAttribute($key, $value, $attrs): ?string
    {
        return $attrs->where('key', $key)->first()->value ?? $value;
    }

    public static function parseMenuAttribute($key, $value, $attrs): ?string
    {
        return $attrs->where('language', app()->getLocale())->first()->{$key} ?? $value;
    }

    public static function getIpnUrl(Payment $payment): string
    {
        return route('api.payment.ipn', [$payment->id, $payment->gateway_id]);
    }

    public static function purseGateway($gateway): ?string
    {
        $gatewayName = $gateway->class_name ?? NotExist::class;
        if (!class_exists($gatewayName)) {
            throw new \Exception('Gateway not properly configured', 500);
        }
        return $gatewayName;
    }

    public static function getStoragePath($url): array|string
    {
        $url = parse_url($url);
        return ltrim($url['path'], '/');
    }

    public static function hasPermission(array $permissions): bool
    {
        $user = request()->user();
        return $user->hasRole('admin') || $user->canAny($permissions);
    }

    public static function parseLocalTimeZone($datetime, $tz = '+03:00'): string
    {
        return Carbon::parse($datetime)->setTimezone(auth()->user()->timezone ?? $tz)->format('d/m/Y h:i a');
    }

    public static function parsePaginator($collections = null, $maxPrice = 0, $title = ''): array
    {
        return [
            'title' => $title,
            'from' => $collections->firstItem() ?? 0,
            'to' => $collections->lastItem() ?? 0,
            'per_page' => $collections->perPage(),
            'current_page' => $collections->currentPage(),
            'last_page' => $collections->lastPage(),
            'total' => $collections->total(),
            'max_price' => $maxPrice,
            'data' => $collections->map(function ($item) {
                return $item->format();
            })
        ];
    }

    public static function createOtp($data)
    {
        return Otp::updateOrCreate($data,
            [
                'code' => self::generateOtp(),
                'revoked' => false
            ]
        );
    }

    public static function generateOtp(): int
    {
        return app()->environment('local') ? 123456 : mt_rand(111111, 999999);
    }

    public static function matchText(string $subject, string $match): bool
    {
        preg_match("/(" . strtolower($match) . ")/", strtolower($subject), $matches, PREG_OFFSET_CAPTURE);
        return (bool)$matches;
    }

    public static function beautifyText($string): ?string
    {
        return ucwords(str_replace(['-', '_'], ' ', $string));
    }

    public static function sanitizePayload(array $payload): array
    {
        $payload = preg_replace("/(')*/", "", array_filter($payload));
        return preg_replace('/(")*/', "", array_filter($payload));
    }

    public static function moduleMessage($module = null, $action = null, $status = true): array
    {
        return [
            'status' => $status,
            'message' => $module ? ucfirst($module) . ' ' . $action . ' successful' : ($status ? 'Success' : 'Failed')
        ];
    }

    public static function shorten($n, $precision = 1): string
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else
            if ($n < 900000) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = 'K';
            } else if ($n < 900000000) {
                // 0.9m-850m
                $n_format = number_format($n / 1000000, $precision);
                $suffix = 'M';
            } else if ($n < 900000000000) {
                // 0.9b-850b
                $n_format = number_format($n / 1000000000, $precision);
                $suffix = 'B';
            } else {
                // 0.9t+
                $n_format = number_format($n / 1000000000000, $precision);
                $suffix = 'T';
            }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . ' ' . $suffix;
    }

    public static function calculateImageSize(int $width, int $height): int
    {
        return round((($width * $height) / 3) / 1024);
    }

    public static function calculateImageRatio(int $width, int $height): string
    {
        $gcd = self::gcd($width, $height);
        $aspectRatioWidth = $width / $gcd;
        $aspectRatioHeight = $height / $gcd;
        return "$aspectRatioWidth:$aspectRatioHeight";
    }

    public static function gcd($a, $b)
    {
        while ($b != 0) {
            $remainder = $a % $b;
            $a = $b;
            $b = $remainder;
        }
        return $a;
    }

    public static function calculatePercentageGrowth($oldNumber, $newNumber): float
    {
        if ($oldNumber == 0) {
            return 100;
        }
        return round((($newNumber - $oldNumber) / $oldNumber) * 100);
    }

    public static function getMenuIcons($path): array
    {
        return preg_grep('~\.(jpeg|jpg|png|svg|gif|bmp)$~', scandir($path));
    }

    public static function attachBadge(mixed $status): string
    {
        $badge = 'default';
        switch (strtolower($status)) {
            case 'pending':
            case 0:
                $badge = 'info';
                break;
            case 'active':
            case 1:
                $badge = 'success';
                break;
            case 'inactive':
            case 2:
                $badge = 'warning';
                break;
            case 'failed':
            case 9:
                $badge = 'danger';
                break;
        }
        return $badge;
    }

    public static function saveVouchers(OrderItem $item, $vouchers, $reference = null): void
    {
        try {
            if (is_array($vouchers)) {
                foreach ($vouchers as $voucher) {
                    $item->vouchers()->save(
                        new Voucher(
                            [
                                'order_id' => $item->order_id,
                                'serial_no' => $voucher['serial_no'] ?? $item->id,
                                'payload' => $voucher,
                                'reference' => $reference,
                            ]
                        )
                    );
                }
            }
        } catch (\Exception $exception) {
            LogHelper::exception($exception, [
                'keyword' => 'VOUCHER_SAVE_EXCEPTION',
            ]);
        }
    }

    public static function orderMessage(Payment $payment): array
    {
        $data = [
            'title' => __($payment->status),
            'message' => __('Your payment :status', ['status' => $payment->status])
        ];

        if ($payment->status == 'pending') {
            $data['title'] = __('Processing');
            $data['message'] = __('Your payment processing');
        }
        return $data;
    }

    public static function parseLimitType($limit_type): string
    {
        return ucwords(str_replace('_', ' ', $limit_type));
    }

    public static function getSerialNo($payload = null)
    {
        $serial = '-';
        try {
            if ($payload && is_array($payload)) {
                foreach ($payload as $k => $v) {
                    if (in_array(Str::slug(strtolower(str_replace('.', '', $k))), ['serial-no', 'Serial No', 'Serial No.', 'serial_number', 'serial', 'serial-number', 'serialnumber'])) {
                        $serial = $v;
                    }
                }
            }
        } catch (\Throwable $th) {
            //
        }

        return (empty($serial)) ? '-' : $serial;
    }

    public static function getPinCode($payload)
    {
        $pin = '-';
        try {
            if ($payload && is_array($payload)) {
                foreach ($payload as $k => $v) {
                    if (in_array(Str::slug(strtolower(str_replace('.', '', $k))), [
                        'pin',
                        'code',
                        'Code',
                        'pin-code',
                        'password',
                        'pin-number',
                        'pin-no',
                        'code-number',
                        'pincode',
                        'card-no',
                        'card-number',
                        'pinnumber'
                    ])) {
                        $pin = $v;
                    }
                }
            }
        } catch (\Throwable $th) {
            //
        }

        return (empty($pin)) ? '-' : $pin;
    }
}
