<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ModuleController extends Controller
{
    /**
     * Display module settings page.
     */
    public function index()
    {
        $modules = $this->getModulesStatus();
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Toggle module status.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'module' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $module = $request->module;
        $status = $request->status;

        $this->updateModuleStatus($module, $status);

        // Clear cache to apply changes
        Artisan::call('cache:clear');

        $message = $status 
            ? "Module '{$module}' has been enabled." 
            : "Module '{$module}' has been disabled.";

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Get all modules and their status.
     */
    public function getModulesStatus()
    {
        $configPath = base_path('modules_statuses.json');
        
        if (!File::exists($configPath)) {
            return [];
        }

        $statuses = json_decode(File::get($configPath), true) ?? [];
        
        // Get all available modules from Modules directory
        $modulesPath = base_path('Modules');
        $availableModules = [];
        
        if (File::exists($modulesPath)) {
            $directories = File::directories($modulesPath);
            foreach ($directories as $directory) {
                $moduleName = basename($directory);
                $availableModules[] = [
                    'name' => $moduleName,
                    'enabled' => isset($statuses[$moduleName]) ? $statuses[$moduleName] : false,
                ];
            }
        }

        return $availableModules;
    }

    /**
     * Update module status in configuration file.
     */
    private function updateModuleStatus($module, $status)
    {
        $configPath = base_path('modules_statuses.json');
        
        $statuses = [];
        if (File::exists($configPath)) {
            $statuses = json_decode(File::get($configPath), true) ?? [];
        }

        $statuses[$module] = $status;

        File::put($configPath, json_encode($statuses, JSON_PRETTY_PRINT));
    }

    /**
     * Get module status (API).
     */
    public function status(Request $request)
    {
        $modules = $this->getModulesStatus();
        return response()->json([
            'success' => true,
            'modules' => $modules
        ]);
    }
}
