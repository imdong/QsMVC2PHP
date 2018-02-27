<?php
/**
 * 控制器 基类
 */
class Controller
{
    /**
     * 视图生成
     *
     * @param string $view 模板文件名 可空
     * @param array  $data  模板数据 可空
     * @return string 生成的模板文本
     */
    public function render($view = null, array $data = []): string
    {
        // 参数一 为数组 则说明忽略参数一
        if(is_array($view)) {
            $data = $view;
            $view = null;
        }

        // 获取模板名
        if(is_null($view)) {
            $tpl_filename = sprintf('%s/%s.html', Core::$route['controller'], Core::$route['action']);
        } else {
            $views = explode('/', $view);
            if(isset($view['1'])) {
                $tpl_filename = $views . '.html';
            } else {
                $tpl_filename = sprintf('%s/%s.html', Core::$route['controller'], $view);
            }
        }

        // 生成模板文件
        $tpl_file = VIEW_PATH . '/' . $tpl_filename;

        // 模板文件是否存在
        if(!file_exists($tpl_file)) {
            die(sprintf('Render Error: Template file (%s) Not found.', $tpl_filename));
        }

        // 处理替换关系
        $replace = [
            'search'  => [],
            'replace' => []
        ];
        foreach ($data as $search => $replace) {
            $replace['search'][]  = sprintf('{$%s}', $search);
            $replace['replace'][] = $replace;
        }

        // 读取模板内容
        $tpl_string = file_get_contents($tpl_file);

        // 替换生成关系
        return str_ireplace($replace['search'], $replace['replace'], $tpl_string);
    }
}
