<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\WPConnectionRepositoryInterface;
use Illuminate\Http\Request;

class WordpressConnectionController extends Controller
{
    protected WPConnectionRepositoryInterface $connections;

    public function __construct(WPConnectionRepositoryInterface $connections)
    {
        $this->connections = $connections;
    }

    public function show()
    {
        $connection = $this->connections->getConnection();
        return response()->json($connection);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'host' => 'required|string',
            'port' => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'prefix' => 'nullable|string',
        ]);

        $connection = $this->connections->updateConnection($data);
        return response()->json($connection);
    }

    public function test(Request $request)
    {
        $data = $request->validate([
            'host' => 'required|string',
            'port' => 'required|numeric',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        try {
            $dsn = "mysql:host={$data['host']};port={$data['port']};dbname={$data['database']}";

            $connection = new \PDO(
                $dsn,
                $data['username'],
                $data['password'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

            return response()->json(['success' => true, 'message' => 'Connection successful!']);
        } catch (\PDOException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ], 400);
        }
    }
}
