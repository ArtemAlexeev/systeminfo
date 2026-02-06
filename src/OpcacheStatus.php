<?php

namespace ArtemAlieksieiev\SystemInfo;

class OpcacheStatus
{
    public function display(): void
    {
        header('Content-Type: application/json');
        $result = $this->getData();

        if (!$result['success']) {
            http_response_code(500);
            echo json_encode(['error' => $result['error']]);
            exit;
        }

        echo json_encode($result['data'], JSON_PRETTY_PRINT);
    }

    private function getData(): array
    {
        $status = opcache_get_status();

        if (false === $status) {
            return [
                'success' => false,
                'error'   => 'Opcache is not enabled or not available.'
            ];
        }

        $status['scripts_count'] = count($status['scripts'] ?? []);
        unset($status['scripts']);

        if (isset($status['memory_usage'])) {
            $this->formatMemorySection($status['memory_usage'],  ['used_memory', 'free_memory']);
        }

        if (isset($status['interned_strings_usage'])) {
            $this->formatMemorySection($status['interned_strings_usage'], ['buffer_size', 'used_memory', 'free_memory']);
        }

        if (isset($status['jit'])) {
            $this->formatMemorySection($status['jit'], ['buffer_size', 'buffer_free']);
        }

        if (isset($status['opcache_statistics']['start_time'])) {
            $status['opcache_statistics']['start_time'] = date(
                'Y-m-d H:i:s',
                $status['opcache_statistics']['start_time']
            );
        }

        return [
            'success' => true,
            'data'    => $status
        ];
    }

    private function formatMemorySection(array &$section, array $keys): void
    {
        foreach ($keys as $key) {
            if (isset($section[$key]) && is_numeric($section[$key])) {
                $section[$key] = $this->bytesToMB((int)$section[$key]);
            }
        }
    }

    private function bytesToMB(int $bytes): string
    {
        return round($bytes / 1024 / 1024) . ' MB';
    }
}
