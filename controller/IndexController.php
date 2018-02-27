<?php
/**
 * 默认控制器
 */
class IndexController extends Controller
{
    /**
     * 空构造函数
     */
    public function __construct()
    {
    }

    /**
     * 首页
     *
     * @return string
     */
    public function index(): string
    {
        return $this->render();
    }
}
